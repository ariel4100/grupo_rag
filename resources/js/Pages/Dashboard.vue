<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Panel
            </h2>
        </template>


        <h2 class="font-semibold text-center py-3 text-gray-800 leading-tight" style="font-size: 2rem">
            Bienvenido {{ $page.user.name || '' }}
        </h2>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'

    export default {
        components: {
            AppLayout,
            Welcome,
        },
    }
</script>
