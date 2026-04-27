<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";

const history = [
    { id: 1, name: 'Downloads_Q1', files: 342, date: 'TODAY, 14:30', status: 'ЗАВЕРШЕН' },
    { id: 2, name: 'Desktop_Old', files: 89, date: 'YESTERDAY, 09:15', status: 'ЗАВЕРШЕН' },
    { id: 3, name: 'Project_Assets', files: 1205, date: 'APR 25, 18:40', status: 'ОШИБКА' },
];
</script>

<template>
    <AppLayout>
        <div class="w-full max-w-4xl mx-auto">
            <header class="mb-10 flex items-end justify-between border-b border-zinc-100 dark:border-zinc-900 pb-6">
                <div>
                    <h1 class="text-2xl font-black uppercase tracking-tighter mb-1">Архив</h1>
                    <p class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.3em]">Журнал оперативного выполнения</p>
                </div>
            </header>

            <div class="bg-white dark:bg-black border border-zinc-100 dark:border-zinc-900 rounded-3xl overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-zinc-50 dark:bg-zinc-900/50 border-b border-zinc-100 dark:border-zinc-900">
                        <tr class="text-[13px] font-black uppercase tracking-[0.3em] text-zinc-400">
                            <th class="px-8 py-5">Источник</th>
                            <th class="px-8 py-5">Количество</th>
                            <th class="px-8 py-5">Время</th>
                            <th class="px-8 py-5 text-right">Статус</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-900 text-[20px] font-black uppercase tracking-widest">
                        <tr v-for="item in history" :key="item.id" class="hover:bg-zinc-50 dark:hover:bg-zinc-900/30 transition-colors text-[12px] cursor-pointer">
                            <td class="px-8 py-6 flex items-center gap-4">
                                <span class="w-6 h-6 rounded border border-zinc-100 dark:border-zinc-800 flex items-center justify-center opacity-40">📁</span>
                                {{ item.name }}
                            </td>
                            <td class="px-10 py-6 opacity-40 font-mono tracking-tighter">{{ item.files }}</td>
                            <td class="px-8 py-6 opacity-40 tracking-tighter">{{ item.date }}</td>
                            <td class="px-8 py-6 text-right">
                                <span :class="item.status === 'ЗАВЕРШЕН' ? 'border-zinc-200 text-zinc-900 dark:border-zinc-800 dark:text-zinc-400' : 'bg-black text-white dark:bg-white dark:text-black'"
                                      class="px-2 py-1 border text-[10px] font-black rounded uppercase">
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
