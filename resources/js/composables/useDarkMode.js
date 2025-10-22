import { ref, onMounted } from 'vue';

const isDark = ref(false);
const initialized = ref(false);

export function useDarkMode() {
    const toggleDarkMode = () => {
        isDark.value = !isDark.value;
        updateTheme();
    };

    const updateTheme = () => {
        if (isDark.value) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
    };

    const initTheme = () => {
        if (initialized.value) return;
        
        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        isDark.value = savedTheme === 'dark' || (!savedTheme && prefersDark);
        updateTheme();
        initialized.value = true;
    };

    onMounted(() => initTheme());

    return {
        isDark,
        toggleDarkMode,
        initTheme
    };
}

