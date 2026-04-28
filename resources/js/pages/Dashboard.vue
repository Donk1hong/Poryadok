<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import { scanStore } from '@/store';

const props = defineProps<{
    path?: string;
}>();

const statusMessage = ref('Анализ данных');

onMounted(() => {
    if (props.path) scanStore.setPath(props.path);
});

watch(() => props.path, (newPath) => {
    if (newPath) scanStore.setPath(newPath);
});

const selectFolder = () => {
    router.post('/select-folder');
};

const startAnalysis = async () => {
    if (!scanStore.path || scanStore.isScanning) return;

    scanStore.start(scanStore.path);
    statusMessage.value = 'Анализ данных';

    const interval = setInterval(() => {
        if (scanStore.progress < 90) {
            scanStore.progress += Math.random() * 2;
        }
    }, 200);

    try {
        const response = await axios.post('/analyze', { path: scanStore.path });

        if (response.data.status === 'downloading') {
            clearInterval(interval);
            statusMessage.value = 'Загрузка модели (5 ГБ)';
            scanStore.progress = 50;

            // Проверяем статус снова через 30 секунд
            setTimeout(startAnalysis, 30000);
            return;
        }

        if (response.data.status === 'success') {
            clearInterval(interval);
            statusMessage.value = 'Готово';
            scanStore.finish();

            setTimeout(() => {
                scanStore.reset();
                router.reload({ only: ['path'] });
            }, 1500);
        }
    } catch (error) {
        clearInterval(interval);
        scanStore.reset();
        statusMessage.value = 'Ошибка';
    }
};
</script>

<template>
    <AppLayout>
        <div class="mx-auto w-full max-w-xl px-6">
            <div
                v-if="!scanStore.path"
                @click="selectFolder"
                class="group relative flex aspect-[16/10] w-full cursor-pointer flex-col items-center justify-center rounded-[2.5rem] border border-zinc-200 bg-white transition-all duration-500 hover:border-black dark:border-zinc-800 dark:bg-zinc-950 dark:hover:border-white"
            >
                <div class="mb-8 flex h-14 w-14 items-center justify-center rounded-2xl border border-zinc-100 transition-all duration-500 group-hover:bg-black group-hover:text-white dark:border-zinc-800 dark:group-hover:bg-white dark:group-hover:text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" />
                    </svg>
                </div>
                <h2 class="text-[10px] font-black uppercase tracking-[0.5em] text-zinc-400 group-hover:text-black dark:group-hover:text-white text-center px-4">Выбрать рабочую директорию</h2>
            </div>

            <div v-else class="w-full space-y-6">
                <div class="relative overflow-hidden rounded-[2.5rem] border border-zinc-200 bg-white p-10 dark:border-zinc-800 dark:bg-black">
                    <div v-if="scanStore.isScanning" class="absolute left-0 top-0 h-[3px] w-full bg-zinc-50 dark:bg-zinc-950">
                        <div class="h-full bg-black transition-all duration-300 ease-out dark:bg-white" :style="{ width: scanStore.progress + '%' }"></div>
                    </div>

                    <div class="mb-14 flex items-center justify-between">
                        <div class="space-y-2 min-w-0">
                            <h3 class="text-[9px] font-black uppercase tracking-[0.3em] text-zinc-400">Системный статус</h3>
                            <p class="text-2xl font-black uppercase tracking-tighter truncate">
                                {{ scanStore.isScanning ? statusMessage : 'Ожидание' }}
                            </p>
                        </div>
                        <div v-if="scanStore.isScanning" class="font-mono text-3xl font-black tracking-tighter italic shrink-0">
                            {{ Math.round(scanStore.progress) }}%
                        </div>
                    </div>

                    <div class="group flex items-center justify-between rounded-2xl border border-zinc-100 bg-zinc-50/50 p-6 dark:border-zinc-900/50 dark:bg-zinc-900/20">
                        <div class="flex min-w-0 items-center gap-5">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-zinc-200 bg-white text-base dark:border-zinc-800 dark:bg-zinc-950">
                                📁
                            </div>
                            <div class="min-w-0">
                                <p class="mb-1 text-[8px] font-black uppercase tracking-widest text-zinc-400">Путь к файлам</p>
                                <p class="truncate font-mono text-[11px] font-bold tracking-tight opacity-70">{{ scanStore.path }}</p>
                            </div>
                        </div>
                        <button
                            @click="selectFolder"
                            v-show="!scanStore.isScanning"
                            class="ml-4 shrink-0 rounded-lg border border-zinc-200 px-4 py-2 text-[9px] font-black uppercase tracking-widest transition-all hover:bg-black hover:text-white dark:border-zinc-800 dark:hover:bg-white dark:hover:text-black"
                        >
                            Сбросить
                        </button>
                    </div>
                </div>

                <button
                    @click="startAnalysis"
                    :disabled="scanStore.isScanning"
                    class="group relative flex h-16 w-full items-center justify-center gap-4 overflow-hidden rounded-[1.5rem] bg-black text-[11px] font-black uppercase tracking-[0.3em] text-white transition-all active:scale-[0.97] disabled:opacity-20 dark:bg-white dark:text-black"
                >
                    <span class="relative z-10">{{ scanStore.isScanning ? statusMessage : 'Запустить Poryadok' }}</span>
                </button>
            </div>
        </div>
    </AppLayout>
</template>
