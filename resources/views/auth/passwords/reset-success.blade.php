<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Success | Church</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-white min-h-screen">
    <div class="h-[50px] bg-[#0d5c2f] w-full"></div>
    
    <div class="flex min-h-[calc(100vh-50px)] p-5">
        <div class="flex-1 flex items-center justify-center">
            <div class="w-[400px] text-center">
                <div class="mb-8">
                    <svg class="mx-auto h-24 w-24 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                
                <h2 class="text-2xl font-bold mb-4">Password Reset Successful!</h2>
                <p class="text-gray-600 mb-8">Your password has been successfully reset. You can now log in with your new password.</p>
                
                <a href="{{ route('login') }}" 
                    class="inline-block px-8 py-3 bg-[#0d5c2f] text-white rounded-lg font-bold hover:bg-[#0d5c2f]/90">
                    Browse Now
                </a>
            </div>
        </div>
        
        <div class="flex-1 flex items-center justify-center">
            <img src="{{ asset('images/church-logo.png') }}" alt="Church" class="w-[60%] h-auto">
        </div>
    </div>
</body>
</html>