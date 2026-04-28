<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';

const page = usePage();
const currentRoute = computed(() => page.url.split('?')[0]);

const isDark = ref(true);

onMounted(() => {
    const savedTheme = localStorage.getItem('theme');
    isDark.value = savedTheme ? savedTheme === 'dark' : true;
    updateTheme(false);
});

const toggleTheme = () => {
    isDark.value = !isDark.value;
    localStorage.setItem('theme', isDark.value ? 'dark' : 'light');
    updateTheme(true);
};

const updateTheme = (animate: boolean) => {
    const doc = document.documentElement;
    if (!animate) doc.classList.add('no-transitions');
    doc.classList.toggle('dark', isDark.value);
    if (!animate) {
        void doc.offsetHeight;
        doc.classList.remove('no-transitions');
    }
};

const navLinks = [
    {
        name: 'Главная',
        href: '/',
        icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
    },
    { name: 'История', href: '/history', icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' },
];

const isActive = (href: string) => (href === '/' ? currentRoute.value === '/' || currentRoute.value === '' : currentRoute.value === href);
</script>

<template>
    <div class="flex h-screen w-full flex-col overflow-hidden" :class="isDark ? 'bg-black text-white' : 'bg-white text-black'">
        <div class="drag relative z-[60] h-8 w-full shrink-0 bg-transparent"></div>

        <div class="grid flex-1 grid-cols-[240px_1fr] overflow-hidden">
            <aside class="z-20 flex h-full flex-col border-r border-zinc-100 bg-inherit dark:border-zinc-900">
                <div class="flex h-16 shrink-0 items-center justify-between px-5">
                    <div class="flex items-center gap-3">
                        <div class="flex h-7 w-7 items-center justify-center rounded">
                            <img src="/icon.png" class="h-8 w-8 object-contain invert dark:invert-0" alt="logo" />
                        </div>
                        <span class="text-[12px] font-black uppercase tracking-[0.3em]">Poryadok</span>
                    </div>

                    <button
                        @click="toggleTheme"
                        class="no-drag flex h-8 w-8 items-center justify-center rounded-full border border-zinc-200 transition-all hover:border-black dark:border-zinc-800 dark:hover:border-white"
                    >
                        <svg
                            v-if="isDark"
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <circle cx="12" cy="12" r="5" />
                            <path
                                d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"
                            />
                        </svg>
                        <svg
                            v-else
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
                        </svg>
                    </button>
                </div>

                <nav class="custom-scrollbar flex-1 space-y-1 overflow-y-auto px-3 pt-6">
                    <Link
                        v-for="link in navLinks"
                        :key="link.name"
                        :href="link.href"
                        class="no-drag group relative flex items-center gap-3 rounded-lg px-4 py-2.5 text-[12px] font-black uppercase tracking-widest transition-all duration-200"
                        :class="
                            isActive(link.href)
                                ? 'bg-black text-white shadow-lg dark:bg-white dark:text-black'
                                : 'text-zinc-400 hover:text-black dark:hover:text-white'
                        "
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="link.icon" />
                        </svg>
                        <span>{{ link.name }}</span>
                    </Link>
                </nav>

                <div class="shrink-0 border-t border-zinc-100 p-4 dark:border-zinc-900">
                    <div class="rounded-lg border border-zinc-100 bg-zinc-50 p-3 dark:border-zinc-900 dark:bg-zinc-900/40">
                        <p class="flex justify-center text-[12px] font-black uppercase tracking-widest text-zinc-200">AI Ollama</p>
                    </div>
                </div>
            </aside>

            <main class="grid-pattern relative flex h-full flex-col items-center justify-center overflow-hidden">
                <div class="custom-scrollbar relative z-10 flex h-full w-full flex-col items-center justify-center overflow-y-auto p-8">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>

<style>
.no-transitions * {
    transition: none !important;
}
</style>
