<template x-if="openModal">
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-primary-dark text-white rounded-xl w-full max-w-xl p-6" 
             x-data="{ selected: [], bannerPreview: null }">
             
            <h2 class="text-2xl font-semibold text-white mb-4">Tell us about your community</h2>
            
            <form id="createForumForm" class="space-y-4" action="{{ route('user.forum.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="topic_ids" :value="JSON.stringify(selected)" />

                <!-- Community Name -->
                <div>
                    <label class="block text-sm mb-1">Community Name</label>
                    <input type="text" name="name" class="w-full p-2 rounded-md bg-secondary-color" placeholder="Name" required>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm mb-1">Description</label>
                    <textarea name="description" class="w-full p-2 rounded-md bg-secondary-color h-24" placeholder="Description"></textarea>
                </div>

                <!-- Banner Image Upload -->
                <div>
                    <label class="block text-2xl mb-2">Add Banner Image</label>
                    
                    <!-- Preview Container -->
                    <div class="relative border-1 border-dashed border-gray-500 bg-secondary-color rounded-md flex flex-col items-center justify-center py-10 w-full h-48 overflow-hidden"
                         :style="bannerPreview ? `background-image: url(${bannerPreview}); background-size: cover; background-position: center;` : ''">
                         
                        <!-- Default Icon (hidden when preview is available) -->
                        <div x-show="!bannerPreview" class="flex flex-col items-center justify-center">
                            <img src="{{ asset('assets/images/icon/photoicon.svg') }}" alt="">
                            <button type="button" 
                                    onclick="document.getElementById('bannerUpload').click()" 
                                    class="mt-4 bg-primary-color px-4 py-2 rounded-3xl text-white">
                                Select File
                            </button>
                        </div>
                        
                        <!-- Remove Preview Button -->
                        <button x-show="bannerPreview" type="button" @click="bannerPreview = null; document.getElementById('bannerUpload').value='';" 
                                class="absolute top-2 right-2 bg-red-600 text-white px-3 py-1 rounded-md text-sm">
                            Remove
                        </button>
                        
                        <input type="file" name="banner" class="hidden" id="bannerUpload" accept="image/*"
                               @change="if($event.target.files.length > 0) { bannerPreview = URL.createObjectURL($event.target.files[0]); }" />
                    </div>
                </div>

                <!-- Topics -->
                <div>
                    <label class="block text-2xl mb-2">Add topics</label>
                    <div class="flex flex-wrap gap-3">
                        @foreach ($topics as $topic)
                        <button
                            type="button"
                            @click="selected.includes('{{ $topic->id }}') 
                            ? selected = selected.filter(t => t !== '{{ $topic->id }}') 
                            : selected.push('{{ $topic->id }}')"
                            :class="selected.includes('{{ $topic->id }}') 
                            ? 'bg-primary-color text-white' 
                            : 'bg-secondary-color text-white'"
                            class="px-4 py-2 rounded-full transition duration-200">
                            {{ $topic->topic }}
                        </button>
                        @endforeach
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-4 mt-4">
                    <button type="button" @click="openModal = false" class="px-4 py-2 text-base border-1 bg-transparent rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-primary-color text-base rounded-lg">Create Community</button>
                </div>
            </form>
        </div>
    </div>
</template>
