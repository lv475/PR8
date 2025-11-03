<script setup>
import { Link, Head } from '@inertiajs/vue3'

const props = defineProps({
    title: String,
    users: Object, 
    flash: String,
})
</script>

<template>
    <Head :title="title" />

    <div class="p-6 space-y-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold">{{ title }}</h1>
 
            <Link
            href="/users/create"
            class="px-3 py-2 rounded bg-blue-600 text-white hover:bg-blue-700"
            >
            Добавить пользователя
            </Link>
        </div>

        <div v-if="flash" class="rounded border border-green-300 bg-green-50 p-3">
            {{ flash }}
        </div>
        <ul class="divide-y divide-gray-200 border rounded">
            <li v-for="u in users.data" :key="u.id" class="p-3 flex justify-between">
                <span>{{ u.name }}</span>
                <span class="text-gray-500">{{ u.email }}</span>
            </li>
        </ul>

        <div class="flex gap-2">
            <Link
                v-for="link in users.links"
                :key="link.label"
                :href="link.url || '#'"
                class="px-2 py-1 rounded border"
                :class="[{ 'bg-blue-600 text-white': link.active }, { 'opacity-50 pointer-events-none': !link.url }]"
                v-html="link.label"
            />
        </div>
    </div>
</template>