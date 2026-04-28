<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { computed } from 'vue';

const props = defineProps<{
    history: Array<{
        id: number;
        folder_name: string;
        files_count: number;
        created_at: string;
    }>;
}>();

const formattedHistory = computed(() => {
    return props.history.map(item => ({
        id: item.id,
        name: item.folder_name,
        files: item.files_count,
        date: new Date(item.created_at).toLocaleString('ru-RU', {
            day: '2-digit',
            month: 'short',
            hour: '2-digit',
            minute: '2-digit'
        }).replace('.', '').toUpperCase(),
        status: 'ЗАВЕРШЕН'
    }));
});
</script>

<template>
    <AppLayout>
        <div class="mx-auto w-full max-w-5xl px-6 pb-20">
            <header class="mb-12 flex items-end justify-between border-b border-zinc-100 pb-8 dark:border-zinc-900">
                <div class="min-w-0">
                    <h1 class="mb-2 text-3xl font-black uppercase tracking-tighter">Архив</h1>
                    <p class="text-[10px] font-black uppercase tracking-[0.4em] text-zinc-400">Системный журнал выполнения операций</p>
                </div>
            </header>

            <div v-if="formattedHistory.length > 0" class="overflow-x-auto rounded-[2rem] border border-zinc-100 bg-white shadow-sm dark:border-zinc-900 dark:bg-black/50 dark:backdrop-blur-xl">
                <table class="w-full table-fixed border-collapse text-left">
                    <colgroup>
                        <col class="w-auto">
                        <col class="w-32">
                        <col class="w-48">
                        <col class="w-40">
                    </colgroup>
                    <thead class="border-b border-zinc-100 bg-zinc-50/50 dark:border-zinc-900 dark:bg-zinc-900/30">
                        <tr class="text-[11px] font-black uppercase tracking-[0.25em] text-zinc-400">
                            <th class="px-8 py-6">Источник</th>
                            <th class="px-8 py-6">Объекты</th>
                            <th class="px-8 py-6">Дата</th>
                            <th class="px-8 py-6 text-right">Статус</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 text-sm font-bold uppercase tracking-tight dark:divide-zinc-900">
                        <tr
                            v-for="item in formattedHistory"
                            :key="item.id"
                            class="group transition-all hover:bg-zinc-50 dark:hover:bg-white/[0.02]"
                        >
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4 min-w-0">
                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg border border-zinc-100 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                                        📁
                                    </div>
                                    <span class="truncate text-[14px] font-black tracking-tight dark:text-zinc-200">{{ item.name }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 font-mono text-[14px] tracking-tighter text-zinc-400 dark:text-zinc-500">
                                {{ item.files }} <span class="text-[9px] opacity-50">PCS</span>
                            </td>
                            <td class="whitespace-nowrap px-8 py-6 text-[13px] text-zinc-400 dark:text-zinc-500">
                                {{ item.date }}
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="inline-block rounded-md border border-zinc-200 bg-zinc-50 px-3 py-1.5 text-[9px] font-black uppercase tracking-widest text-zinc-900 dark:border-zinc-800 dark:bg-zinc-900/50 dark:text-zinc-400">
                                    {{ item.status }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else class="flex h-64 flex-col items-center justify-center rounded-[2rem] border-2 border-dashed border-zinc-100 dark:border-zinc-900">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400">История операций пуста</p>
            </div>
        </div>
    </AppLayout>
</template>
