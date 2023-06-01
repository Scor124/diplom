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
                        <div class="container mt-4">
                            <div class="row">
                                <div class="col-12">
                                    <div v-if="id===1017" class="container-fluid mx-2 px-3 d-flex justify-content-between">
                                        <Link class="btn btn-outline-secondary mx-2 hover:text-blue-400 text-gray-200" :href="route('admin.users')" :ref="route('admin.users')">
                                            Пользователи
                                        </Link>
                                        <Link class="btn btn-outline-primary mx-2 hover:text-blue-400 text-gray-200" :href="route('admin.classes')" :ref="route('admin.classes')">
                                            Группы
                                        </Link>
                                        <Link class="btn btn-outline-primary mx-2 hover:text-blue-400 text-gray-200" :href="route('admin.students')" :ref="route('admin.students')">
                                            Студенты
                                        </Link>
                                    </div>
                                    <div v-if="isTeacher = false" class="container-fluid flex justify-center font-semibold">
                                        <div >
                                            <Link :href="route('mymarks')" :ref="route('mymarks')">
                                                Посмортеть оценки
                                            </Link>
                                        </div>
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
