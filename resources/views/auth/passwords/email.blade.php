<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Church</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-white min-h-screen">
    <div class="h-[50px] bg-[#0d5c2f] w-full"></div>
    
    <div class="flex min-h-[calc(100vh-50px)] p-5">
        <div class="flex-1 flex items-center justify-center">
            <div class="w-[400px]">
                <h2 class="text-2xl font-bold mb-6 text-center">Reset Password</h2>

                @if (session('status'))
                    <div class="mb-4 text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                            class="w-full p-3 border border-[#0d5c2f] rounded text-base @error('email') border-red-500 @enderror">
                        
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                        class="w-full p-3 bg-[#0d5c2f] text-white rounded-lg cursor-pointer text-base font-bold hover:bg-[#0d5c2f]/90">
                        Send Password Reset Link
                    </button>

                    <p class="mt-4 text-sm text-gray-600 text-center">
                        Remember your password? 
                        <a href="{{ route('login') }}" class="text-[#0d5c2f] hover:text-[#0d5c2f]/80">Login here</a>
                    </p>
                </form>
            </div>
        </div>
        
        <div class="flex-1 flex items-center justify-center">
            <img src="{{ asset('images/church-logo.png') }}" alt="Church" class="w-[60%] h-auto">
        </div>
    </div>
</body>
</html>