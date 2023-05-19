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
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div>
                        <div v-if="id===1017" class="container-fluid text-center">
                            <div class="row justify-content-center mx-auto ">
                                <button class="btn btn-outline-primary m-2 hover:text-blue-400 text-gray-200">
                                    <Link :href="route('admin.users')" :ref="route('admin.users')">
                                        Пользователи
                                    </Link>
                                </button>
                                <span> | </span>
                                <button class="btn btn-outline-primary m-2 hover:text-blue-400 text-gray-200">
                                    <Link :href="route('admin.classes')" :ref="route('admin.classes')">
                                        Группы
                                    </Link>
                                </button>
                                <span> | </span>
                                <button class="btn border-gray-400 btn-outline-primary m-2 hover:text-blue-400 text-gray-200">
                                    <Link  :href="route('admin.students')" :ref="route('admin.students')">
                                        Студенты
                                    </Link>
                                </button>
                            </div>
                        </div>
                        <div class="container-fluid flex justify-center font-semibold">
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

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
