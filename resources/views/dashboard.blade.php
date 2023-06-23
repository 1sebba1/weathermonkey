<html>
    <head>
        @vite('resources/css/app.css')
		
    </head>
	<body class="h-screen bg-gradient-to-b
	from-white to-black">
		
	<div class="w-full mt-16 lg:mt-64 lg:px-40 justify-center container mx-auto ">
	
		
		
		<form method="POST" action="{{ route('search') }}"> 
	@csrf  
    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
    <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
		<input type="search" id="default-search" name="search" class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Tell us where you'd like to see the weather for" required>
        <button type="submit" class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
    </div>
</form>

		<div class="flex flex-wrap w-full lg:w-auto">
			<div class="w-full lg:w-1/2 flex rounded-lg bg-auto" style="background-image: url('https://images.unsplash.com/photo-1559963110-71b394e7494d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=675&q=80')">
				<div class="rounded-lg py-6 pl-8 pr-32 w-full bg-blue-400 opacity-90 text-white">
					<div class="mb-20">
						<h2 class="font-bold text-3xl leading-none pb-1">{{$today}}</h2>
						<h3 class="leading-none pb-2 pl-1">{{$todaysDate}}</h3>
						<p class="flex aling-center opacity-75"><svg class=" w-4 inline mr-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"  viewBox="0 0 425.963 425.963" style="enable-background:new 0 0 425.963 425.963;" xml:space="preserve" class=""><g><g><path d="M213.285,0h-0.608C139.114,0,79.268,59.826,79.268,133.361c0,48.202,21.952,111.817,65.246,189.081   c32.098,57.281,64.646,101.152,64.972,101.588c0.906,1.217,2.334,1.934,3.847,1.934c0.043,0,0.087,0,0.13-0.002   c1.561-0.043,3.002-0.842,3.868-2.143c0.321-0.486,32.637-49.287,64.517-108.976c43.03-80.563,64.848-141.624,64.848-181.482   C346.693,59.825,286.846,0,213.285,0z M274.865,136.62c0,34.124-27.761,61.884-61.885,61.884   c-34.123,0-61.884-27.761-61.884-61.884s27.761-61.884,61.884-61.884C247.104,74.736,274.865,102.497,274.865,136.62z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFFFFF"/></svg>
						{{"${name}, ${country}"}}
						</p>
					</div>
					<div>
						<img class="w-24 mb-2" src="{{'https://openweathermap.org/img/wn/'. $icon.'@2x.png'}}">
						<strong class="leading-none text-6xl block font-weight-bolder">{{"${temp}ºC"}}</strong>
						<b class="text-2xl block font-bold">{{$description}}</b>
					</div>
				</div>
			</div>
	
			<div class="w-full lg:w-1/2 flex ml-0">
				<div class="lg:my-3 bg-gray-800 text-white p-8 lg:rounded-r-lg w-full">
					<div class="flex justify-between w-64 mb-4 w-full">
						<div class="w-auto font-bold uppercase text-90">Feels Like</div><div class="w-auto text-right">{{"${feelsLike}ºC"}}</div>
					</div>
					<div class="flex justify-between w-64 mb-4 w-full">
						<div class="w-auto font-bold uppercase text-90">Humidity</div><div class="w-auto text-right">{{"$humidity%"}}</div>
					</div>
					<div class="flex justify-between w-64 mb-8 w-full">
						<div class="w-auto font-bold uppercase text-90">Wind</div><div class="w-auto text-right">{{"${speed}"."MPH"}}</div>
					</div>
					<div class="flex flex-row">
						<div class="flex flex-col w-1/4 m-1 bg-gray-900 rounded-lg pb-4">
							<div class="text-center pt-2 mb-2">
								<img class="w-10 mx-auto object-fill" src="{{'https://openweathermap.org/img/wn/'. $forecastData[0]['icon'].'@2x.png'}}">

							</div>
							<div class="text-center">
								<b class="font-normal">{{$forecastData[0]['day']}}</b><br>
								<strong class="text-xl">{{$forecastData[0]['temp']."ºC"}}</strong>
							</div>
						</div>
	
						<div class="flex flex-col w-1/4 m-1 bg-gray-900 rounded-lg">
							<div class="text-center pt-2 mb-2">
								<img class="w-10 mx-auto object-fill" src="{{'https://openweathermap.org/img/wn/'. $forecastData[1]['icon'].'@2x.png'}}">

							</div>
							<div class="text-center">
								<b class="font-normal">{{$forecastData[1]['day']}}</b><br>
								<strong class="text-xl">{{$forecastData[1]['temp']."ºC"}}</strong>
							</div>
						</div>
						<div class="flex flex-col w-1/4 m-1 bg-gray-900 rounded-lg">
							<div class="text-center pt-2 mb-2">
								<img class="w-10 mx-auto" src="{{'https://openweathermap.org/img/wn/'. $forecastData[2]['icon'].'@2x.png'}}">
							</div>
							<div class="text-center">
								<b class="font-normal">{{$forecastData[2]['day']}}</b><br>
								<strong class="text-xl">{{$forecastData[2]['temp']."ºC"}}</strong>
							</div>
						</div>
						<div class="flex flex-col w-1/4 m-1 bg-gray-900 rounded-lg">
							<div class="text-center pt-2 mb-2">
								<img class="w-10 mx-auto" src="{{'https://openweathermap.org/img/wn/'. $forecastData[3]['icon'].'@2x.png'}}">

							</div>
							<div class="text-center">
								<b class="font-normal">{{$forecastData[3]['day']}}</b><br>
								<strong class="text-xl">{{$forecastData[3]['temp']."ºC"}}</strong>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</body>
</html>