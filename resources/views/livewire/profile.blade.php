<div class="p-6 bg-white text-black dark:bg-gray-900 dark:text-white min-h-screen">
    <div class="bg-gray-800 rounded p-4 text-white">
        <div class="flex items-center space-x-4">
            <img src="https://static.vecteezy.com/system/resources/thumbnails/027/951/137/small_2x/stylish-spectacles-guy-3d-avatar-character-illustrations-png.png"
                class="rounded-full w-16 h-16" />
            <div>
                <h2 class="text-2xl font-bold">{{ $user->name }} <span
                        class="text-sm text-gray-400">{{ $user->clan ? '[' . $user->clan . ']' : '' }}</span></h2>
                <p class="text-sm text-gray-400">Level {{ $user->level }} • KR: {{ number_format($user->kr) }}</p>
                <p class="text-sm text-gray-400">Since {{ $user->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    <div class="mt-6 bg-gray-800 p-4 rounded">
        <div>
            <div class="flex justify-between space-x-1 mb-2">
                <button wire:click="tabs('general')"
                    class="px-2 py-1 @if ($activeTab == 'general') bg-blue-300 dark:bg-blue-700 @else bg-gray-400 dark:bg-gray-700 @endif rounded text-lg">General
                    Stats</button>
                <button wire:click="tabs('killstreaks')"
                    class="px-2 py-1 @if ($activeTab == 'killstreaks') bg-blue-300 dark:bg-blue-700 @else bg-gray-400 dark:bg-gray-700 @endif rounded text-lg">Killstreaks
                    Stats</button>
                <button wire:click="tabs('others')"
                    class="px-2 py-1 @if ($activeTab == 'others') bg-blue-300 dark:bg-blue-700 @else bg-gray-400 dark:bg-gray-700 @endif rounded text-lg">Others
                    Stats</button>
                <button wire:click="tabs('class')"
                    class="px-2 py-1 @if ($activeTab == 'class') bg-blue-300 dark:bg-blue-700 @else bg-gray-400 dark:bg-gray-700 @endif rounded text-lg">Class
                    Stats</button>
            </div>           

            @if ($activeTab == 'general')
                {{-- <h3 class="text-lg text-center font-semibold mb-2">General Stats</h3> --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center text-sm border-t border-gray-600 pt-2">
                    <x-stat label="Level" :value="$user->level" />
                    <x-stat label="KR" :value="$user->kr" />
                    <x-stat label="Junk" :value="number_format($user->junk ?? 0, 2)" />
                    <x-stat label="Score" :value="number_format($user->score ?? 0)" />
                    <x-stat label="Kills" :value="$user->kills" />
                    <x-stat label="Deaths" :value="$user->deaths" />
                    <x-stat label="KDR" :value="number_format($user->kills / max($user->deaths, 1), 2)" />
                    <x-stat label="KPG" :value="number_format($user->kills / max($user->games, 1), 2)" />
                    <x-stat label="Games Played" :value="$user->games" />
                    <x-stat label="Wins" :value="$user->wins" />
                    <x-stat label="Losses" :value="$user->games - $user->wins" />
                    <x-stat label="Assists" :value="$user->assists" />
                    <x-stat label="Melee Kills" :value="$user->melee" />
                    <x-stat label="Headshots" :value="$user->headshots" />
                    <x-stat label="Wallbangs" :value="$user->wallbangs" />
                    <x-stat label="Shots" :value="$user->shots" />
                    <x-stat label="Hits" :value="$user->hits" />
                    <x-stat label="Misses" :value="$user->misses" />
                    <x-stat label="Accurancy" :value="$user->shots > 0 ? round(($user->hits / $user->shots) * 100, 2) . '%' : 0 . '%'" />
                    <x-stat label="Time Played" :value="$user->time_played" />
                </div>
            @elseif ($activeTab == 'killstreaks')
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center text-sm border-t border-gray-600 pt-2">
                    <x-stat label="Nukes" :value="0" />
                    <x-stat label="Airdrops" :value="0" />
                    <x-stat label="Airdrop Stolen" :value="0" />
                    <x-stat label="Slimers" :value="0" />
                    <x-stat label="Juggernauts" :value="0" />
                    <x-stat label="Juggernauts Killed" :value="0" />
                    <x-stat label="War Machines" :value="0" />
                </div>
            @elseif ($activeTab == 'others')
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center text-sm border-t border-gray-600 pt-2">
                    <x-stat label="Crouches" :value="0" />
                    <x-stat label="Spray Placed" :value="0" />
                    <x-stat label="Helpful Reports" :value="0" />
                    <x-stat label="Total Calls" :value="0" />
                    <x-stat label="Bans from Calls" :value="0" />
                </div>
            @elseif ($activeTab == 'class')
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center text-sm border-t border-gray-600 pt-2">
                    <x-stat label="Triggerman" :value="0" />
                    <x-stat label="Hunter" :value="0" />
                    <x-stat label="Run N Gun" :value="0" />
                    <x-stat label="Spray N Pray" :value="0" />
                    <x-stat label="Vince" :value="0" />
                    <x-stat label="Detective" :value="0" />
                    <x-stat label="Marksman" :value="0" />
                    <x-stat label="Rocketeer" :value="0" />
                    <x-stat label="Agent" :value="0" />
                    <x-stat label="Runner" :value="0" />
                    <x-stat label="Bowman" :value="0" />
                    <x-stat label="Commando" :value="0" />
                    <x-stat label="Tropper" :value="0" />
                    <x-stat label="Infiltrator" :value="0" />
                </div>
            @endif
        </div>
    </div>
</div>
