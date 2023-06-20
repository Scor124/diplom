<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link } from '@inertiajs/vue3';
import {onActivated} from "vue";

defineProps({
    id:{
        type: BigInt,
    },
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
                <div class="bg-dots-darker dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div>
                        <div class="container">
                            <div class="row">
                                <div class="col-12 ">
                                    <div v-if="id===1017" class="container-fluid m-5 p-3 d-flex justify-content-start">
                                        <Link class="btn btn-outline-secondary mx-2 hover:text-blue-400 text-gray-200" :href="route('admin.users')" :ref="route('admin.users')">
                                            Пользователи
                                        </Link>
                                        <Link class="btn btn-outline-primary mx-2 hover:text-blue-400 text-gray-200" :href="route('admin.classes')" :ref="route('admin.classes')">
                                            Группы
                                        </Link>
                                        <Link class="btn btn-outline-primary mx-2 hover:text-blue-400 text-gray-200" :href="route('admin.teachers')" :ref="route('admin.teachers')">
                                            Преподаватели
                                        </Link>
                                    </div>
                                    <div class="container-fluid m-5 p-3 d-flex justify-content-start font-semibold">
                                        <Link class="btn btn-outline-primary mx-2 hover:text-blue-400 text-gray-200" :href="route('mymarks')" :ref="route('mymarks')" v-if="isTeacher===false">
                                            Посмортеть оценки
                                        </Link>
                                        <Link class="btn btn-outline-primary mx-2 hover:text-blue-400 text-gray-200" :href="route('marks')" :ref="route('marks')" v-else>
                                            Выставить оценки
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
