<nav class="fixed top-0 right-0 sm:left-80 left-0 z-30 p-6 border-b border-gray-300">
    <div class="flex items-center justify-between">
        <div class="flex flex-col">            
            @if(!empty($breadcrumb))
                <nav class="flex items-center gap-2 text-xs font-medium text-gray-500 mb-2">   
                    @foreach($breadcrumb as $label => $url)
                        @if(!$loop->first)
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                        @endif

                        @if($url)
                            <a href="{{ $url }}" class="hover:text-{{$color}} transition-colors">
                                {{ $label }}
                            </a>
                        @else
                            <span class="text-gray-600 font-semibold cursor-default">
                                {{ $label }}
                            </span>
                        @endif
                    @endforeach
                </nav>
            @endif

            <div class="flex items-center gap-x-4">
                <h1 class="text-3xl font-semibold text-{{ $color }} tracking-tight">
                    {{ $title }}
                </h1>

                @if(isset($action))
                    {{ $action }}
                @endif
            </div>
        </div>

        <div class="flex items-center gap-4">
            <button type="button" class="relative group p-2 bg-white rounded-full shadow-xs border border-gray-300 hover:bg-gray-100 hover:border-gray-400 transition-all duration-200 focus:outline-none focus:ring-0 cursor-pointer">
                <span class="sr-only">Ver notificações</span>
                
                <svg class="w-6 h-6 text-{{ $color }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z" clip-rule="evenodd" />
                </svg>

                <span class="absolute top-0 right-0 flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-{{ $color }} opacity-75"></span>

                    <span class="relative inline-flex rounded-full h-3 w-3 bg-{{ $color }} border-2 border-white"></span>
                </span>
            </button>

            <div class="relative">
                <button data-dropdown-toggle="dropdown-user" type="button" class="flex items-center gap-3 p-2 bg-white rounded-xl shadow-xs border border-gray-300 hover:bg-gray-100 hover:border-gray-400 transition-all group duration-200 cursor-pointer focus:outline-none focus:ring-0">
                    <div class="h-9 w-9 rounded-full bg-{{$color}}/10 flex items-center justify-center text-{{ $color }} font-bold border-2 border-white shadow-xs uppercase">
                        {{ substr($user->name, 0, 2) }}
                    </div>

                    <div class="text-left hidden md:block">
                        <p class="text-sm font-semibold text-gray-700 leading-none">
                            {{ $user->name }}
                        </p>
                        
                        <p class="text-xs font-medium text-gray-400 mt-0.5">
                            {{ $type }} 
                        </p>
                    </div>

                    <svg class="w-4 h-4 text-gray-400 hover:text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>

                <div id="dropdown-user" class="z-50 hidden text-base list-none bg-white divide-y divide-gray-100 rounded shadow-lg w-44">
                    <div class="p-2" role="none">
                        <p class="text-sm text-gray-900" role="none">
                            {{ $user->name }}
                        </p>

                        <p class="text-sm font-medium text-gray-900 truncate" role="none">
                            {{ $user->email }}
                        </p>
                    </div>

                    <ul class="p-2" role="none">
                        <li>
                            <a href="#" class="block p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">Meu Perfil</a>
                        </li>
                        <li>
                            
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>