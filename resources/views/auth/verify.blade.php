<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email | Church</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-white min-h-screen">
    <div class="h-[50px] bg-[#0d5c2f] w-full"></div>
    
    <div class="flex min-h-[calc(100vh-50px)] p-5">
        <div class="flex-1 flex items-center justify-center">
            <div class="w-[600px]">
                <h1 class="text-4xl font-bold mb-4 text-center">Verify Your Email Address</h1>
                
                @if (session('resent'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        A fresh verification link has been sent to your email address.
                    </div>
                @endif

                <p class="mb-4 text-center text-gray-600">
                    Before proceeding, please check your email for a verification link.
                    If you did not receive the email,
                </p>

                <form method="POST" action="{{ route('verification.resend') }}" class="flex flex-col items-center">
                    @csrf
                    <button type="submit" 
                        class="w-[300px] p-3 bg-[#0d5c2f] text-white rounded-lg cursor-pointer text-base font-bold hover:bg-[#0d5c2f]/90 mb-4">
                        Click here to request another
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="flex flex-col items-center">
                    @csrf
                    <button type="submit" 
                        class="w-[300px] p-3 border border-[#0d5c2f] text-[#0d5c2f] rounded-lg cursor-pointer text-base font-bold hover:bg-gray-50">
                        Logout
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