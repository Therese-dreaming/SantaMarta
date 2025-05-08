<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create An Account | Church</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-white min-h-screen">
    <div class="h-[50px] bg-[#0d5c2f] w-full"></div>
    
    <div class="flex min-h-[calc(100vh-50px)] p-5">
        <div class="flex-1 flex items-center justify-center">
            <div class="w-[600px]">
                <h1 class="text-6xl font-bold mb-8 text-center">Create An Account</h1>
                <form method="POST" action="{{ route('register') }}" class="flex flex-col items-center">
                    @csrf
                    <div class="mb-4 w-[400px]">
                        <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required 
                            class="w-full p-3 border border-[#0d5c2f] rounded text-base @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4 w-[400px]">
                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required 
                            class="w-full p-3 border border-[#0d5c2f] rounded text-base @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4 w-[400px]">
                        <input type="password" name="password" placeholder="Password" required 
                            class="w-full p-3 border border-[#0d5c2f] rounded text-base @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-sm mt-1">Password must be at least 8 characters</p>
                    </div>

                    <button type="submit" 
                        class="w-[200px] p-3 bg-[#0d5c2f] text-white rounded-lg cursor-pointer text-base font-bold hover:bg-[#0d5c2f]/90">
                        SIGNUP
                    </button>
                </form>
            </div>
        </div>
        
        <div class="flex-1 flex items-center justify-center">
            <img src="{{ asset('images/church-logo.png') }}" alt="Church" class="w-[60%] h-auto">
        </div>
    </div>
</body>
</html>