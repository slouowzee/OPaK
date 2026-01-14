<x-app-layout>
    <!-- Create Post Form -->
    <div class="border-b border-gray-800 p-4" 
        x-data="{ 
            openModal: false, 
            files: [], 
            error: null,
            totalSize: 0,
            MAX_SIZE: 40 * 1024 * 1024,
            isDragging: false,
            
            formatSize(bytes) {
                if(bytes === 0) return '0 B';
                const k = 1024;
                const sizes = ['B', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            },
            
            addFiles(fileList) {
                this.error = null;
                let tempSize = this.totalSize;
                let newFiles = [];
                
                for (let i = 0; i < fileList.length; i++) {
                    if (tempSize + fileList[i].size > this.MAX_SIZE) {
                        this.error = 'La taille totale ne doit pas dépasser 40 Mo.';
                        return;
                    }
                    tempSize += fileList[i].size;
                    newFiles.push(fileList[i]);
                }
                
                this.files = this.files.concat(newFiles);
                this.totalSize = tempSize;
                this.openModal = false;
            },
            
            removeFile(index) {
                this.totalSize -= this.files[index].size;
                this.files.splice(index, 1);
            },
            
            dropHandler(e) {
                this.isDragging = false;
                this.addFiles(e.dataTransfer.files);
            }
        }">
        
        <form method="POST" action="{{ route('messages.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="flex gap-4">
                <div class="w-12 h-12 bg-gray-700 rounded-full flex-shrink-0 overflow-hidden">
                    <svg class="w-full h-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <textarea 
                        name="content"
                        placeholder="Quoi de neuf ?" 
                        class="w-full bg-transparent text-xl text-white placeholder-gray-500 border-none focus:ring-0 resize-none h-24"
                        maxlength="140"    
                    ></textarea>
                    
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- File Previews -->
                    <div class="mt-2 grid grid-cols-2 gap-2" x-show="files.length > 0">
                        <template x-for="(file, index) in files" :key="index">
                            <div class="bg-gray-800 rounded p-2 flex items-center justify-between group">
                                <div class="flex items-center gap-2 overflow-hidden">
                                     <div class="bg-gray-700 p-1 rounded text-xs text-white uppercase" x-text="file.name.split('.').pop()"></div>
                                     <div class="text-sm text-gray-200 truncate" x-text="file.name"></div>
                                </div>
                                <button type="button" @click="removeFile(index)" class="text-gray-500 hover:text-red-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </template>
                    </div>
                    
                    <div x-show="error" class="text-red-500 text-sm mt-1" x-text="error"></div>

                    <div class="flex justify-between items-center mt-2 border-t border-gray-800 pt-3">
                        <div class="flex gap-2 text-blue-400">
                           <!-- Import Media Button -->
                           <button type="button" @click="openModal = true" class="text-blue-400 hover:bg-blue-900/30 p-2 rounded-full flex items-center gap-2 transition" title="Importer un média">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="hidden sm:inline text-sm font-medium">Média</span>
                           </button>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-full disabled:opacity-50">
                            Poster
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Upload Modal -->
        <div x-show="openModal" 
             style="display: none;"
             class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 backdrop-blur-sm p-4"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
             
            <div class="bg-black border border-gray-800 rounded-3xl w-full max-w-lg p-6 relative shadow-2xl" @click.outside="openModal = false">
                <!-- Close Button -->
                <button @click="openModal = false" class="absolute top-4 right-4 text-gray-500 hover:text-white transition bg-gray-900 hover:bg-gray-800 rounded-full p-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <h3 class="text-xl font-black mb-6 text-white">Média</h3>
                
                <div class="border-2 border-dashed border-gray-800 rounded-2xl h-64 flex flex-col items-center justify-center text-center transition-all group hover:border-blue-500/50 hover:bg-blue-500/5"
                     :class="{ 'border-blue-500 bg-blue-500/10': isDragging }"
                     @dragover.prevent="isDragging = true"
                     @dragleave.prevent="isDragging = false"
                     @drop.prevent="dropHandler($event)">
                     
                     <div class="w-16 h-16 bg-gray-900 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                     </div>
                     
                     <p class="text-lg font-bold text-white mb-2">Glissez vos fichiers ici</p>
                     
                     <button @click="$refs.fileInput.click()" class="mt-2 text-sm font-bold text-blue-400 hover:text-blue-300 hover:underline">
                         Parcourir les fichiers
                     </button>
                     
                     <input type="file" multiple class="hidden" x-ref="fileInput" @change="addFiles($event.target.files)">
                </div>
                
                <div class="mt-6 flex justify-between items-center border-t border-gray-800 pt-4">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Limite : 40 Mo</span>
                    <span class="font-mono text-sm text-blue-400 font-bold" x-text="formatSize(totalSize)"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Feed -->
    <div>
        @foreach($messages as $message)
            <div class="border-b border-gray-800 p-4 hover:bg-gray-900/50 transition cursor-pointer">
                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-gray-700 rounded-full flex-shrink-0 overflow-hidden">
                        <svg class="w-full h-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-1">
                            <span class="font-bold text-white">{{ $message->user->name }}</span>
                            <span class="text-gray-500 text-sm">&#64;{{ strtolower(str_replace(' ', '', $message->user->name)) }}</span>
                            <span class="text-gray-500 text-sm">·</span>
                            <span class="text-gray-500 text-sm hover:underline">{{ $message->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-200 text-base leading-snug">
                            {{ $message->content }}
                        </p>
                        
                        <!-- Post Actions -->
                        <div class="flex items-center gap-6 mt-2 text-gray-500">
                            <button class="text-gray-400 hover:text-white text-sm transition font-medium">
                                Réponse.
                            </button>
                            <button class="text-gray-400 hover:text-pink-400 text-sm transition font-medium flex items-center">
                                <span class="font-mono text-sm mr-0.5">{{ $message->likes_count ?? 0 }}</span>
                                <span class="text-gray-400 mx-0.5">•</span>
                                <span>J'aime</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @if($messages->isEmpty())
            <div class="p-8 text-center text-gray-500">
                <p class="text-xl mb-2">C'est un peu vide ici...</p>
                <p>Soyez le premier à poster quelque chose !</p>
            </div>
        @endif
    </div>
</x-app-layout>
