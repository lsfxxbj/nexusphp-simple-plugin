<x-filament-panels::page>
    <div class="flex flex-col space-y-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Simple Plugin</h1>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Plugin Information</h2>
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="font-medium">Plugin Name:</span>
                    <span>Simple Plugin</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Version:</span>
                    <span>1.0.0</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Status:</span>
                    <span class="text-green-600">Active</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Description:</span>
                    <span>A simple plugin for NexusPHP</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
            <div class="grid grid-cols-2 gap-4">
                <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded transition-colors">
                    Test Action 1
                </a>
                <a href="#" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded transition-colors">
                    Test Action 2
                </a>
            </div>
        </div>
    </div>
</x-filament-panels::page>