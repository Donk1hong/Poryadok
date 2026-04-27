<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{ path?: string }>();
const isScanning = ref(false);
const progress = ref(0);

const selectFolder = () => router.post('/select-folder');

const startAnalysis = () => {
    isScanning.value = true;
    const interval = setInterval(() => {
        progress.value += 1;
        if (progress.value >= 100) {
            progress.value = 100;
            clearInterval(interval);
            setTimeout(() => { isScanning.value = false; progress.value = 0; }, 500);
        }
    }, 40);
};
</script>

<template>
    <AppLayout>
        <div class="w-full max-w-xl mx-auto">
            <div v-if="!path" @click="selectFolder"
                 class="group relative w-full aspect-video border-[1px] border-zinc-200 dark:border-zinc-800 rounded-3xl flex flex-col items-center justify-center cursor-pointer transition-all duration-300 hover:border-black dark:hover:border-white bg-white dark:bg-zinc-950/50 backdrop-blur-sm">

                <div class="w-12 h-12 mb-6 border border-zinc-100 dark:border-zinc-800 rounded flex items-center justify-center group-hover:bg-black dark:group-hover:bg-white group-hover:text-white dark:group-hover:text-black transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>

                <h2 class="text-[12px] font-black uppercase tracking-[0.4em] mb-2">Импортировать папку</h2>
                <div class="h-px w-8 bg-zinc-200 dark:border-zinc-800 group-hover:w-12 transition-all"></div>
            </div>

            <div v-else class="w-full space-y-4">
                <div class="bg-white dark:bg-black border border-zinc-200 dark:border-zinc-800 rounded-3xl p-8 relative overflow-hidden shadow-2xl">
                    <div v-if="isScanning" class="absolute top-0 left-0 w-full h-[2px] bg-zinc-100 dark:bg-zinc-900">
                        <div class="h-full bg-black dark:bg-white transition-all duration-100" :style="{ width: progress + '%' }"></div>
                    </div>

                    <div class="flex items-center justify-between mb-12">
                        <div class="space-y-1">
                            <h3 class="text-xs font-black uppercase tracking-widest opacity-40">Статус</h3>
                            <p class="text-lg font-black uppercase tracking-tighter">{{ isScanning ? 'Оптимизация' : 'Готов' }}</p>
                        </div>
                        <div v-if="isScanning" class="flex flex-col items-end">
                            <span class="text-xl font-black font-mono tracking-tighter">{{ Math.round(progress) }}%</span>
                        </div>
                    </div>

                    <div class="border border-zinc-100 dark:border-zinc-800 rounded-2xl p-5 flex items-center justify-between group bg-zinc-50 dark:bg-zinc-900/20">
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="w-8 h-8 rounded border border-zinc-200 dark:border-zinc-700 flex items-center justify-center shrink-0 opacity-50 text-xs">📁</div>
                            <div class="min-w-0">
                                <p class="text-[10px] font-black uppercase tracking-widest opacity-40 mb-1">Целевой каталог</p>
                                <p class="text-[12px] font-bold truncate font-mono tracking-tight">{{ path }}</p>
                            </div>
                        </div>
                        <button @click="selectFolder" v-show="!isScanning" class="text-[8px] font-black uppercase tracking-widest border border-zinc-200 dark:border-zinc-700 px-3 py-1.5 rounded-md hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-all">Изменить</button>
                    </div>
                </div>

                <button @click="startAnalysis" :disabled="isScanning"
                        class="w-full h-14 bg-black dark:bg-white text-white dark:text-black rounded-2xl font-black uppercase tracking-[0.2em] text-[10px] transition-all active:scale-[0.98] disabled:opacity-30 flex items-center justify-center gap-4">
                    {{ isScanning ? 'Обработка метаданных' : 'Начать сканирование' }}
                    <svg v-if="!isScanning" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
            </div>
        </div>
    </AppLayout>
</template>
