<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';

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
    { name: 'Главная', href: '/', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
    { name: 'История', href: '/history', icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' },
];

const isActive = (href: string) => (href === '/' ? currentRoute.value === '/' || currentRoute.value === '' : currentRoute.value === href);
</script>

<template>
    <div class="flex flex-col h-screen w-full overflow-hidden" :class="isDark ? 'bg-black text-white' : 'bg-white text-black'">

        <div class="h-8 w-full shrink-0 drag bg-transparent relative z-[60]"></div>

        <div class="grid grid-cols-[240px_1fr] flex-1 overflow-hidden">
            <aside class="flex flex-col border-r border-zinc-100 dark:border-zinc-900 z-20 h-full bg-inherit">

                <div class="h-16 flex items-center px-5 shrink-0 justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded flex items-center justify-center">
                            <img src="/icon.png" class="w-8 h-8 object-contain invert dark:invert-0" alt="logo" />
                        </div>
                        <span class="text-[12px] font-black uppercase tracking-[0.3em]">Poryadok</span>
                    </div>

                    <button @click="toggleTheme" class="no-drag w-8 h-8 flex items-center justify-center rounded-full border border-zinc-200 dark:border-zinc-800 hover:border-black dark:hover:border-white transition-all">
                        <svg v-if="isDark" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" stroke-width="2.5" />
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" stroke-width="2.5" />
                        </svg>
                    </button>
                </div>

                <nav class="flex-1 space-y-1 px-3 pt-6 overflow-y-auto custom-scrollbar">
                    <Link v-for="link in navLinks" :key="link.name" :href="link.href"
                        class="group relative flex items-center gap-3 rounded-lg px-4 py-2.5 text-[12px] font-black uppercase tracking-widest transition-all duration-200 no-drag"
                        :class="isActive(link.href) ? 'bg-black text-white dark:bg-white dark:text-black shadow-lg' : 'text-zinc-400 hover:text-black dark:hover:text-white'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="link.icon" />
                        </svg>
                        <span>{{ link.name }}</span>
                    </Link>
                </nav>

                <div class="p-4 shrink-0 border-t border-zinc-100 dark:border-zinc-900">
                    <div class="rounded-lg p-3 border border-zinc-100 dark:border-zinc-900 bg-zinc-50 dark:bg-zinc-900/40">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-[12px] font-black uppercase tracking-widest text-zinc-400">AI Лимиты</span>
                            <span class="text-[12px] font-black tracking-tighter">70%</span>
                        </div>
                        <div class="h-0.5 w-full bg-zinc-200 dark:bg-zinc-800 overflow-hidden">
                            <div class="h-full bg-black dark:bg-white w-[70%]"></div>
                        </div>
                    </div>
                </div>
            </aside>

            <main class="relative flex flex-col items-center justify-center h-full overflow-hidden grid-pattern">
                <div class="relative z-10 w-full h-full flex flex-col items-center justify-center p-8 overflow-y-auto custom-scrollbar">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>

<style>
/* Performance fix for theme lag */
.no-transitions * {
    transition: none !important;
}
</style>
