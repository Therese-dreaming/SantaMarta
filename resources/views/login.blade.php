<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Church</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-white min-h-screen">
    <div class="h-[50px] bg-[#0d5c2f] w-full"></div>
    
    <div class="flex min-h-[calc(100vh-50px)] p-5">
        <div class="flex-1 flex items-center justify-center">
            <div class="w-[600px]">
                <h1 class="text-6xl font-bold mb-8 text-center">Login</h1>
                
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 font-medium text-sm text-red-600">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}" class="flex flex-col items-center">
                    @csrf
                    <div class="mb-4 w-[400px]">
                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus
                            class="w-full p-3 border border-[#0d5c2f] rounded text-base @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6 w-[400px]">
                        <input type="password" name="password" placeholder="Password" required
                            class="w-full p-3 border border-[#0d5c2f] rounded text-base @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6 w-[400px] flex items-center justify-between">
                        <a href="{{ route('password.request') }}" class="text-sm text-[#0d5c2f] hover:text-[#0d5c2f]/80">
                            Forgot password?
                        </a>
                    </div>

                    <button type="submit" 
                        class="w-[200px] p-3 bg-[#0d5c2f] text-white rounded-lg cursor-pointer text-base font-bold hover:bg-[#0d5c2f]/90">
                        LOGIN
                    </button>

                    <p class="mt-4 text-sm text-gray-600">
                        Don't have an account? 
                        <a href="{{ route('signup') }}" class="text-[#0d5c2f] hover:text-[#0d5c2f]/80">Sign up</a>
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