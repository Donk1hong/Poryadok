import { reactive } from 'vue';

export const scanStore = reactive({
    isScanning: false,
    progress: 0,
    path: null as string | null,

    setPath(newPath: string | null) {
        this.path = newPath;
    },

    start(path: string) {
        this.isScanning = true;
        this.progress = 0;
        this.path = path;
    },

    finish() {
        this.isScanning = false;
        this.progress = 100;
    },

    reset() {
        this.isScanning = false;
        this.progress = 0;
    }
});
