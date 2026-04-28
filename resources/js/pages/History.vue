<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';

const history = [
    { id: 1, name: 'DOWNLOADS_Q1', files: 342, date: 'СЕГОДНЯ, 14:30', status: 'ЗАВЕРШЕН' },
    { id: 2, name: 'DESKTOP_OLD', files: 89, date: 'ВЧЕРА, 09:15', status: 'ЗАВЕРШЕН' },
    { id: 3, name: 'PROJECT_ASSETS', files: 1205, date: '25 АПР, 18:40', status: 'ОШИБКА' },
];
</script>

<template>
    <AppLayout>
        <div class="mx-auto w-full max-w-5xl px-6">
            <header class="mb-12 flex items-end justify-between border-b border-zinc-100 pb-8 dark:border-zinc-900">
                <div>
                    <h1 class="mb-2 text-3xl font-black uppercase tracking-tighter">Архив</h1>
                    <p class="text-[10px] font-black uppercase tracking-[0.4em] text-zinc-400">Системный журнал выполнения операций</p>
                </div>
            </header>

            <div class="overflow-hidden rounded-[2rem] border border-zinc-100 bg-white shadow-sm dark:border-zinc-900 dark:bg-black/50 dark:backdrop-blur-xl">
                <table class="w-full border-collapse text-left">
                    <thead class="border-b border-zinc-100 bg-zinc-50/50 dark:border-zinc-900 dark:bg-zinc-900/30">
                        <tr class="text-[11px] font-black uppercase tracking-[0.25em] text-zinc-400">
                            <th class="px-10 py-6">Источник / Директория</th>
                            <th class="px-10 py-6">Объекты</th>
                            <th class="px-10 py-6">Временная метка</th>
                            <th class="px-10 py-6 text-right">Состояние</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 text-sm font-bold uppercase tracking-tight dark:divide-zinc-900">
                        <tr
                            v-for="item in history"
                            :key="item.id"
                            class="group cursor-pointer transition-all hover:bg-zinc-50 dark:hover:bg-white/[0.02]"
                        >
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-5">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-xl border border-zinc-100 bg-white text-lg shadow-sm transition-transform group-hover:scale-110 dark:border-zinc-800 dark:bg-zinc-900">
                                        📁
                                    </div>
                                    <span class="text-[15px] font-black tracking-tight dark:text-zinc-200">{{ item.name }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-8 font-mono text-[15px] tracking-tighter text-zinc-400 dark:text-zinc-500">
                                {{ item.files }} <span class="text-[10px] font-black ml-1 opacity-50">FILES</span>
                            </td>
                            <td class="px-10 py-8 text-zinc-400 dark:text-zinc-500 text-[14px]">
                                {{ item.date }}
                            </td>
                            <td class="px-10 py-8 text-right">
                                <span
                                    :class="
                                        item.status === 'ЗАВЕРШЕН'
                                            ? 'border-zinc-200 bg-zinc-50 text-zinc-900 dark:border-zinc-800 dark:bg-zinc-900/50 dark:text-zinc-400'
                                            : 'bg-black text-white dark:bg-white dark:text-black shadow-lg dark:shadow-white/5'
                                    "
                                    class="inline-block rounded-lg border px-4 py-2 text-[10px] font-black uppercase tracking-widest transition-transform group-hover:scale-105"
                                >
                                    {{ item.status }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.dark .shadow-sm {
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.5);
}
</style>
