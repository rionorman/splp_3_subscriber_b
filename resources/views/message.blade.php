<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rabbitmq-tut</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased">
    <div class="h-[100vh] flex justify-center items-center ">
        <form action="/api/rabbit/send" method="post" class="w-[700px]">
            <textarea class="border border-gray-300 w-full rounded-[10px] min-h-[300px] p-4" placeholder="enter message" name="message" id="message"></textarea>
            {{ csrf_field() }} 
            <button class="bg-blue-500 px-10 py-[12px] rounded-[10px] text-white mt-2">Send message</button>
        </form>
    </div>
</body>
</html>