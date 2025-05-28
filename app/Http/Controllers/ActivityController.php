<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    /**
     * Display a listing of the activities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Activity::with('user'); // Eager load the user relationship
        
        // Apply type filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        // Apply date range filters
        if ($request->filled('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }
        
        // Apply booking status filter
        if ($request->filled('block')) {
            $query->where('block_bookings', $request->block);
        }
        
        // Order by date (newest first) and then by start time
        $activities = $query->orderBy('date', 'desc')
                            ->orderBy('start_time')
                            ->paginate(10)
                            ->withQueryString();
        
        return view('admin.activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new activity.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.activities.create');
    }

    /**
     * Store a newly created activity in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:mass,meeting,event,holiday,maintenance',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'description' => 'nullable|string',
            'recurrence' => 'nullable|string|in:none,daily,weekly,monthly,yearly',
            'recurrence_end_date' => 'nullable|date|after_or_equal:date',
            'block_bookings' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'There was an error with your submission.');
        }

        $activity = new Activity();
        $activity->title = $request->title;
        $activity->type = $request->type;
        $activity->date = $request->date;
        $activity->start_time = $request->start_time;
        $activity->end_time = $request->end_time;
        $activity->description = $request->description;
        $activity->recurrence = $request->recurrence ?? 'none';
        $activity->recurrence_end_date = $request->recurrence_end_date;
        $activity->block_bookings = $request->has('block_bookings');
        $activity->created_by_id = auth()->id();
        $activity->save();

        // If this is a recurring activity, create future instances
        if ($activity->recurrence !== 'none') {
            $this->createRecurringActivities($activity);
        }

        return redirect()->route('admin.activities.index')
            ->with('success', 'Activity created successfully.');
    }

    /**
     * Show the form for editing the specified activity.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        return view('admin.activities.edit', compact('activity'));
    }

    /**
     * Update the specified activity in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:mass,meeting,event,holiday,maintenance',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'recurrence' => 'required|string|in:none,daily,weekly,monthly,yearly',
            'block_bookings' => 'required|boolean',
            'description' => 'nullable|string',
        ]);

        // Check if end time is after start time
        if ($request->start_time >= $request->end_time) {
            return back()->withInput()->with('error', 'End time must be after start time');
        }

        $activity->update([
            'title' => $request->title,
            'type' => $request->type,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'recurrence' => $request->recurrence,
            'block_bookings' => $request->block_bookings,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.activities.index')
            ->with('success', 'Activity updated successfully');
    }

    /**
     * Remove the specified activity from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        // Check if there are any bookings associated with this activity
        // If you have a relationship with bookings, you might want to add this check
        
        $activity->delete();
        
        return redirect()->route('admin.activities.index')
            ->with('success', 'Activity deleted successfully');
    }

    /**
     * Create recurring activities based on the original activity.
     *
     * @param  \App\Models\Activity  $activity
     * @return void
     */
    private function createRecurringActivities(Activity $activity)
    {
        $startDate = \Carbon\Carbon::parse($activity->date);
        
        // Use the provided end date or default to one year
        $endDate = $activity->recurrence_end_date 
            ? \Carbon\Carbon::parse($activity->recurrence_end_date) 
            : $startDate->copy()->addYear();
        
        $interval = match($activity->recurrence) {
            'daily' => '1 day',
            'weekly' => '1 week',
            'monthly' => '1 month',
            'yearly' => '1 year',
            default => null,
        };
        
        if (!$interval) {
            return;
        }
        
        $currentDate = $startDate->copy()->add($interval);
        
        while ($currentDate->lte($endDate)) {
            $newActivity = $activity->replicate();
            $newActivity->date = $currentDate->format('Y-m-d');
            $newActivity->created_by_id = $activity->created_by_id;
            $newActivity->save();
            
            $currentDate->add($interval);
        }
    }
}