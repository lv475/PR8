<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'

const props = defineProps({
    title: String,
    roles: Array, 
})

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: props.roles?.[0] ?? null,
})

function submit() {
    form.post('/users', {
        onSuccess: () => {
            form.reset('password', 'password_confirmation')
        }
    })
}

</script>

<template>
    <Head :title="title" />

    <div class="p-6 space-y-6 max-w-xl">
        <div class="flex items-center gap-3">
            <Link href="/users" class="text-blue-600 hover:underline">← Назад к списку</Link>
            <h1 class="text-2xl font-semibold">{{ title }}</h1>
        </div>

    <form @submit.prevent="submit" class="space-y-4">
        <div>
            <label class="block mb-1">Имя</label>
            <input v-model.trim="form.name" type="text" class="w-full border rounded p-2" placeholder="Иван" />
            <div v-if="form.errors.name" class="text-red-600 text-sm mt-1">{{ form.errors.name }}</div>
        </div>

        <div>
            <label class="block mb-1">E-mail</label>
            <input v-model.trim="form.email" type="email" class="w-full border rounded p-2" placeholder="ivan@example.com" />
            <div v-if="form.errors.email" class="text-red-600 text-sm mt-1">{{ form.errors.email }}</div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1">Пароль</label>
                <input v-model.lazy="form.password" type="password" class="w-full border rounded p-2" />
                <div v-if="form.errors.password" class="text-red-600 text-sm mt-1">{{ form.errors.password }}</div>
            </div>

            <div>
                <label class="block mb-1">Повтор пароля</label>
                <input v-model.lazy="form.password_confirmation" type="password" class="w-full border rounded p-2" />
            </div>
        </div>

        <div>
            <label class="block mb-1">Тип аккаунта</label>
            <div class="flex gap-4">
                <label v-for="r in roles" :key="r" class="inline-flex items-center gap-2">
                    <input type="radio" :value="r" v-model="form.role" />
                    <span class="capitalize">{{ r }}</span>
                </label>
            </div>
            <div v-if="form.errors.role" class="text-red-600 text-sm mt-1">{{ form.errors.role }}</div>
        </div>

        <div class="flex items-center gap-3">
            <button
                :disabled="form.processing"
                class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700 disabled:opacity-50"
            >
                Создать
            </button>

            <span v-if="form.progress" class="text-sm text-gray-500">
        Загрузка: {{ form.progress.percentage }}%
        </span>
        </div>
    </form>
    </div>
</template>