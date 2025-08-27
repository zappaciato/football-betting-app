<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Football Betting App</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-gray-100{--tw-bg-opacity: 1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.border-gray-200{--tw-border-opacity: 1;border-color:rgb(229 231 235 / var(--tw-border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{--tw-shadow: 0 1px 3px 0 rgb(0 0 0 / .1), 0 1px 2px -1px rgb(0 0 0 / .1);--tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)}.text-center{text-align:center}.text-gray-200{--tw-text-opacity: 1;color:rgb(229 231 235 / var(--tw-text-opacity))}.text-gray-300{--tw-text-opacity: 1;color:rgb(209 213 219 / var(--tw-text-opacity))}.text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}.text-gray-600{--tw-text-opacity: 1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-700{--tw-text-opacity: 1;color:rgb(55 65 81 / var(--tw-text-opacity))}.text-gray-900{--tw-text-opacity: 1;color:rgb(17 24 39 / var(--tw-text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--tw-bg-opacity: 1;background-color:rgb(31 41 55 / var(--tw-bg-opacity))}.dark\:bg-gray-900{--tw-bg-opacity: 1;background-color:rgb(17 24 39 / var(--tw-bg-opacity))}.dark\:border-gray-700{--tw-border-opacity: 1;border-color:rgb(55 65 81 / var(--tw-border-opacity))}.dark\:text-white{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.dark\:text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}}
        <link rel="stylesheet" href="/path/to/football-icons/css/football-icons.min.css" />
        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased bg-gradient-to-br from-green-500 via-teal-500 to-blue-600 text-white min-h-screen flex items-center justify-center">
    <div class="text-center max-w-lg px-6">
        <!-- Logo / Icon -->
         <!-- Football-like Logo -->
<!-- Modern Football Logo -->
<!-- Artistic Modern Football Logo -->
<!-- Artistic Realistic Football Logo -->
<div class="flex justify-center mb-6">
    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 200 200" width="200.0pt" height="200.0pt">
<path d="M 0.00 0.00 L 98.78 0.00 L 98.54 0.18 C 97.49 0.94 96.43 1.65 95.34 2.34 C 79.80 11.43 64.20 20.44 48.69 29.59 C 44.49 57.42 40.25 85.25 35.99 113.08 C 54.91 139.10 73.94 165.05 92.90 191.05 C 95.01 193.98 97.36 196.88 99.16 200.00 L 0.00 200.00 L 0.00 0.00 Z" fill="#ffffff" />
<path d="M 98.78 0.00 L 99.84 0.00 L 100.03 0.12 L 100.29 0.30 C 101.76 1.33 103.27 2.28 104.82 3.19 C 119.89 11.86 134.87 20.66 149.95 29.30 C 154.40 57.19 158.63 85.12 163.00 113.03 C 141.89 142.04 120.56 170.94 99.53 200.00 L 99.16 200.00 C 97.36 196.88 95.01 193.98 92.90 191.05 C 73.94 165.05 54.91 139.10 35.99 113.08 C 40.25 85.25 44.49 57.42 48.69 29.59 C 64.20 20.44 79.80 11.43 95.34 2.34 C 96.43 1.65 97.49 0.94 98.54 0.18 L 98.78 0.00 Z" fill="#f50303" />
<path d="M 99.84 0.00 L 200.00 0.00 L 200.00 200.00 L 99.53 200.00 C 120.56 170.94 141.89 142.04 163.00 113.03 C 158.63 85.12 154.40 57.19 149.95 29.30 C 134.87 20.66 119.89 11.86 104.82 3.19 C 103.27 2.28 101.76 1.33 100.29 0.30 L 100.03 0.12 L 99.84 0.00 Z" fill="#ffffff" />
<path d="M 99.26 5.03 C 114.97 13.78 130.48 23.07 146.09 32.04 C 150.25 58.68 154.38 85.32 158.50 111.97 C 138.77 138.86 119.24 165.95 99.34 192.71 C 79.80 165.77 60.08 138.95 40.49 112.04 C 44.49 85.45 48.65 58.89 52.56 32.30 C 68.06 23.10 83.67 14.07 99.26 5.03 Z" fill="#000000" />
<path d="M 88.00 37.06 C 91.97 39.16 95.71 41.67 99.71 43.73 C 103.43 41.42 107.22 39.20 111.00 36.98 C 114.80 39.18 118.56 41.44 122.37 43.62 C 124.02 44.64 125.74 45.44 126.85 47.07 C 129.28 50.55 131.60 54.13 133.79 57.77 C 128.52 57.79 123.26 57.64 118.00 57.60 C 114.64 57.20 111.47 60.08 108.66 61.67 C 109.02 63.89 109.35 66.12 109.73 68.33 C 110.93 66.96 112.09 65.55 113.26 64.15 C 115.54 64.24 117.85 64.44 120.13 64.29 C 123.37 63.18 126.37 61.32 129.50 59.92 C 130.12 63.60 130.66 67.30 131.17 71.00 C 128.43 73.29 125.30 75.27 122.82 77.84 C 121.80 79.84 121.27 82.11 120.54 84.22 C 121.73 86.80 122.99 89.35 124.24 91.90 C 122.61 94.08 121.12 96.48 119.19 98.40 C 116.86 99.32 114.27 99.63 111.83 100.21 C 108.39 97.99 105.00 95.69 101.71 93.26 C 102.33 91.33 102.83 89.31 103.67 87.47 C 105.51 85.08 108.32 83.47 110.22 81.11 C 110.52 80.00 110.57 78.82 110.71 77.69 C 103.02 77.71 95.32 77.76 87.63 77.78 C 88.37 72.39 89.32 67.02 90.26 61.66 C 87.99 60.27 85.68 58.58 83.13 57.75 C 77.16 57.42 71.15 57.89 65.17 57.59 C 67.94 53.68 70.22 49.06 73.51 45.59 C 78.19 42.55 83.11 39.75 88.00 37.06 Z" fill="#ffffff" />
<path d="M 70.65 60.52 C 73.55 61.75 76.26 63.49 79.22 64.55 C 80.84 64.75 82.52 64.56 84.15 64.54 C 84.77 68.99 85.45 73.49 85.85 77.96 C 84.16 75.67 82.83 73.12 81.06 70.90 C 79.17 69.94 76.60 70.19 74.57 69.46 C 72.83 68.08 71.37 66.33 69.80 64.76 C 70.07 63.34 70.35 61.93 70.65 60.52 Z" fill="#ffffff" />
<path d="M 88.73 81.25 C 90.97 83.31 93.49 85.21 95.46 87.53 C 96.51 89.33 97.08 91.45 97.82 93.39 C 94.62 95.76 91.29 97.92 87.97 100.11 C 85.21 99.53 82.28 99.20 79.63 98.22 C 77.72 96.39 76.28 94.02 74.68 91.91 C 75.90 89.36 77.12 86.81 78.36 84.27 C 81.81 83.23 85.27 82.23 88.73 81.25 Z" fill="#ffffff" />
<path d="M 93.27 100.32 C 97.28 99.83 101.76 99.91 105.80 100.23 C 109.32 101.82 112.52 104.15 115.87 106.08 C 116.38 109.01 116.87 111.95 117.33 114.90 C 113.06 120.66 108.85 126.47 104.55 132.21 C 102.74 130.05 101.08 127.79 99.42 125.50 C 97.88 127.73 96.33 129.96 94.77 132.17 C 90.26 126.52 86.16 120.54 81.75 114.80 C 82.13 111.89 82.60 109.00 83.08 106.11 C 86.48 104.22 89.73 101.94 93.27 100.32 Z" fill="#ffffff" />
</svg>
</div>



<!-- 
        <div class="flex justify-center mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-yellow-300 drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.477 2 2 6.477 2 12c0 4.507 2.98 8.313 7.054 9.57a1 1 0 00.632-1.894A7.005 7.005 0 015 12c0-3.86 3.14-7 7-7s7 3.14 7 7a7.005 7.005 0 01-4.686 6.676 1 1 0 00.632 1.894C19.02 20.313 22 16.507 22 12c0-5.523-4.477-10-10-10z"/>
            </svg>
        </div> -->

        <!-- App Name -->
        <h1 class="text-4xl font-extrabold tracking-tight mb-2 drop-shadow-lg">
            Football Betting App
        </h1>

        <!-- Byline -->
        <p class="text-lg text-yellow-200 mb-8 font-medium drop-shadow">
            @byKrzysztofFlakiewicz
        </p>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" 
                        class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-semibold px-6 py-3 rounded-full shadow-lg transition transform hover:scale-105">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                        class="bg-white text-green-700 hover:bg-gray-200 font-semibold px-6 py-3 rounded-full shadow-lg transition transform hover:scale-105">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" 
                            class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-semibold px-6 py-3 rounded-full shadow-lg transition transform hover:scale-105">
                            Register
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</body>

</html>
