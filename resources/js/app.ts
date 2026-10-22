import { createInertiaApp } from '@inertiajs/vue3';
import { initializeTheme } from '@/composables/useAppearance';
import AppLayout from '@/layouts/AppLayout.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { initializeFlashToast } from '@/lib/flashToast';

const appName = import.meta.env.VITE_APP_NAME || 'TK PGRI Tamansari';

void createInertiaApp({
    title: (title) => (title ? (title.includes(appName) ? title : `${title} - ${appName}`) : appName),
    layout: (name) => {
        // Public and admin pages wrap themselves in GuestLayout/AdminLayout, so the
        // default AppLayout would otherwise nest an authenticated shell around them.
        switch (true) {
            case name === 'Beranda':
            case name === 'Profil':
            case name === 'Program':
            case name === 'Galeri':
            case name === 'Kontak':
            case name.startsWith('berita/'):
            case name.startsWith('admin/'):
            case name.startsWith('auth/'):
                return null;
            case name.startsWith('settings/'):
                return [AppLayout, SettingsLayout];
            default:
                return AppLayout;
        }
    },
    withApp: (app) => {
        app.directive('focus', {
            mounted: (el: HTMLElement, shouldFocus) => {
                if (shouldFocus.value !== false) {
                    el.focus();
                }
            },
        });
    },
    progress: {
        color: '#006738',
    },
});

// This will set light / dark mode on page load...
initializeTheme();

// This will listen for flash toast data from the server...
initializeFlashToast();
