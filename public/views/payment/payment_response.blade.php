<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $message }}</title>
    @vite('resources/css/app.css')
    <link rel="icon" type="image/x-icon" href="logo_black.png">
</head>

<body class="mx-auto max-w-screen-xl bg-gray-200">
    <div class="h-screen bg-gray-200 flex justify-center items-center ">
        <div class="bg-white md:w-3/5 h-4/5 rounded-lg mx-4 shadow-xl flex flex-col justify-start items-center gap-8">
            <div class="w-32 mt-10">
                <img loading="lazy"  src="logo_black.png" alt="">
            </div>
            <div class="">
                <h1 class="font-car font-bold text-gray-900 text-6xl text-center"><h2>{{ $message }}</h2></h1>
            </div>
            <div class="relative bg-gray-200 md:w-3/5 m-4 md:mt-10">
                <div
                    class="w-0 h-0 absolute -top-[29px] left-[215px] border-l-[20px] border-l-transparent border-b-[30px] border-b-gray-200 border-r-[20px] border-r-transparent">
                </div>
                <div class="p-3">
                    <p class="text-lg font-car text-gray-600 text-justify">{{ $detail }}</p>
                </div>

            </div>
        </div>



    </div>
</body>

</html>
