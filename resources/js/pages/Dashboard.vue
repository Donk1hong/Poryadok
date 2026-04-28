<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps<{ path?: string }>();

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
            setTimeout(() => {
                isScanning.value = false;
                progress.value = 0;
            }, 500);
        }
    }, 40);
};
</script>

<template>
    <AppLayout>
        <div class="mx-auto w-full max-w-xl">
            <div
                v-if="!path"
                @click="selectFolder"
                class="group relative flex aspect-video w-full cursor-pointer flex-col items-center justify-center rounded-3xl border-[1px] border-zinc-200 bg-white backdrop-blur-sm transition-all duration-300 hover:border-black dark:border-zinc-800 dark:bg-zinc-950/50 dark:hover:border-white"
            >
                <div
                    class="mb-6 flex h-12 w-12 items-center justify-center rounded border border-zinc-100 transition-all group-hover:bg-black group-hover:text-white dark:border-zinc-800 dark:group-hover:bg-white dark:group-hover:text-black"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>

                <h2 class="mb-2 text-[12px] font-black uppercase tracking-[0.4em]">ВЫБРАТЬ ПАПКУ</h2>
                <div class="h-px w-8 bg-zinc-200 transition-all group-hover:w-12 dark:border-zinc-800"></div>
            </div>

            <div v-else class="w-full space-y-4">
                <div class="relative overflow-hidden rounded-3xl border border-zinc-200 bg-white p-8 shadow-2xl dark:border-zinc-800 dark:bg-black">
                    <div v-if="isScanning" class="absolute left-0 top-0 h-[2px] w-full bg-zinc-100 dark:bg-zinc-900">
                        <div class="h-full bg-black transition-all duration-100 dark:bg-white" :style="{ width: progress + '%' }"></div>
                    </div>

                    <div class="mb-12 flex items-center justify-between">
                        <div class="space-y-1">
                            <h3 class="text-xs font-black uppercase tracking-widest opacity-40">СТАТУС</h3>
                            <p class="text-lg font-black uppercase tracking-tighter">{{ isScanning ? 'АНАЛИЗ' : 'ГОТОВО' }}</p>
                        </div>
                        <div v-if="isScanning" class="flex flex-col items-end">
                            <span class="font-mono text-xl font-black tracking-tighter">{{ Math.round(progress) }}%</span>
                        </div>
                    </div>

                    <div
                        class="group flex items-center justify-between rounded-2xl border border-zinc-100 bg-zinc-50 p-5 dark:border-zinc-800 dark:bg-zinc-900/20"
                    >
                        <div class="flex min-w-0 items-center gap-4">
                            <div
                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded border border-zinc-200 text-xs opacity-50 dark:border-zinc-700"
                            >
                                📁
                            </div>
                            <div class="min-w-0">
                                <p class="mb-1 text-[10px] font-black uppercase tracking-widest opacity-40">ПУТЬ</p>
                                <p class="truncate font-mono text-[12px] font-bold tracking-tight">{{ path }}</p>
                            </div>
                        </div>
                        <button
                            @click="selectFolder"
                            v-show="!isScanning"
                            class="rounded-md border border-zinc-200 px-3 py-1.5 text-[10px] font-black uppercase tracking-widest transition-all hover:bg-black hover:text-white dark:border-zinc-700 dark:hover:bg-white dark:hover:text-black"
                        >
                            ИЗМЕНИТЬ
                        </button>
                    </div>
                </div>

                <button
                    @click="startAnalysis"
                    :disabled="isScanning"
                    class="flex h-14 w-full items-center justify-center gap-4 rounded-2xl bg-black text-[10px] font-black uppercase tracking-[0.2em] text-white transition-all active:scale-[0.98] disabled:opacity-30 dark:bg-white dark:text-black"
                >
                    {{ isScanning ? 'ОБРАБОТКА ДАННЫХ' : 'ЗАПУСТИТЬ ИИ' }}
                    <svg v-if="!isScanning" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
            </div>
        </div>
    </AppLayout>
</template>
