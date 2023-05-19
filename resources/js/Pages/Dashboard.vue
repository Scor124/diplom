<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link } from '@inertiajs/vue3';
import {onActivated} from "vue";
defineProps({
    isTeacher:{
        type: Boolean,
    },
    isVerified:{
        type: Boolean,
    }
});
</script>

<template>
    <Head title="Активности" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Активность</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div>
                        <div v-if="isVerified" class="container-fluid text-center">
                            <div class="row justify-content-center mx-auto">
                                <Link class="col-4 btn btn-primary" :href="route('admin.users')" :ref="route('admin.users')">
                                    Пользователи
                                </Link>
                                <Link class="col-4 btn btn-link" :href="route('admin.classes')" :ref="route('admin.classes')">
                                    Группы
                                </Link>
                                <Link class="col-4 btn btn-link" :href="route('admin.students')" :ref="route('admin.students')">
                                    Студенты
                                </Link>
                            </div>
                        </div>
                        <Link v-if="isTeacher" :href="route('classes')" :ref="route('classes')">
                            Посмортеть группы
                        </Link>
                        <template v-else>
                            <div>
                                <Link :href="route('mymarks')" :ref="route('mymarks')">
                                    Посмортеть оценки
                                </Link>
                            </div>
                        </template>
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">Вы вошли!</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
