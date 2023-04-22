<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectButton from '@/Components/SelectInput.vue';
import WarningButton from '@/Components/WarningButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import Swal from 'sweetalert2';
import vueTailwindPaginationUmd from '@ocrv/vue-tailwind-pagination';
import SelectInput from '@/Components/SelectInput.vue';

const nameInput = ref(null);
const modal = ref(false);
const title = ref('');
const operation = ref(1);
const id = ref('');

const props = defineProps({
    employees: {type:Object},
    departments: {type:Object}
});

const form = useForm({
    name:'', email:'', phone:'', department_id:''
});

const formPage = useForm({});

const onPageClick = (event)=>{
    formPage.get(route('employees.index',{page:event}));
}

const openModal = (op,name,email,phone,department,employee) =>{
    modal.value = true;
    nextTick( () => nameInput.value.focus());
    operation.value = op;
    id.value = employee;
    if(op == 1){
        title.value = 'Cadastrar Colaborador';
    }
    else{
        title.value = 'Editar Cadastro do Colaborador';
        form.name = name;
        form.email = email;
        form.phone = phone;
        form.department_id = department;
    }
}

const closeModal = () =>{
    modal.value = false;
    form.reset();
}

const save = () =>{
    if(operation.value == 1){
        form.post(route('employees.store'),{
            onSuccess: () => {ok('Cadastro Efetuado')}
        });
    }
    else {
        form.put(route('employees.update', id.value),{
            onSuccess: () => {ok('Atualização de Cadastro Efetuada')}
        });
    }
}

const ok = (msg) =>{
    form.reset();
    closeModal();
    Swal.fire({title:msg, icon:'success'})
}

const deleteEmployee = (id, name) => {
    const alerta = Swal.mixin({
        buttonsStyling:true
    });
    alerta.fire({
        title: 'Você quer mesmo deletar '+name+' ?',
        icon: 'question', showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i> Sim, deletar',
        cancelButtonText:'<i class="fa-solid fa-ban"></i> Cancelar'

    }).then((result) => {
        if(result.isConfirmed) {
            form.delete(route('employees.destroy',id),{
                onSuccess: () =>{ok('Cadastro de Colaborador Apagado')}
            });
        }
    })
}

</script>

<template>
    <Head title="Employees" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Colaboradores</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <PrimaryButton @click="$event => openModal(1)">
                        <i class="fa-solid fa-plus-circle"></i> Adicionar
                    </PrimaryButton>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center overflow-x-auto">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2">#</th>
                            <th class="px-2 py-2">Nome</th>
                            <th class="px-2 py-2">Email</th>
                            <th class="px-2 py-2">Phone</th>
                            <th class="px-2 py-2">Departamento</th>
                            <th class="px-2 py-2"></th>
                            <th class="px-2 py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="emp, i in employees.data" :key="emp.id">
                            <td class="border border-gray-400 px-2 py-2">{{ (i+1) }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ emp.name }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ emp.email }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ emp.phone }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ emp.department }}</td>
                            <td class="border border-gray-400 px-2 py-2">
                                <WarningButton
                                @click="$event => openModal(2, emp.name, emp.email, emp.phone, emp.department_id, emp.id)">
                                    <i class="fa-solid fa-edit"></i>
                                </WarningButton>
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                <DangerButton @click="$event => deleteEmployee(emp.id,emp.name)">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <vueTailwindPaginationUmd
                    :current="employees.currentPage" :total="employees.total"
                    :per-page="employees.perPage"
                    @page-changed="$event => onPageClick($event)"
                ></vueTailwindPaginationUmd>
            </div>
        </div>
        <Modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font.medium text-hray-900">{{ title }}</h2>
            <div class="p-3">
                <InputLabel for="name" value="Nome:"></InputLabel>
                <TextInput id="name" ref="nameInput"
                v-model="form.name" type="text" class="mt-1 block w-3/4"
                placeholder="Digite seu nome"></TextInput>
                <InputError :message="form.errors.name" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="email" value="Email:"></InputLabel>
                <TextInput id="email"
                v-model="form.email" type="text" class="mt-1 block w-3/4"
                placeholder="Digite seu email"></TextInput>
                <InputError :message="form.errors.email" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="phone" value="Phone:"></InputLabel>
                <TextInput id="phone"
                v-model="form.phone" type="text" class="mt-1 block w-3/4"
                placeholder="Digite seu telefone"></TextInput>
                <InputError :message="form.errors.phone" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="department_id" value="Departamento:"></InputLabel>
                <SelectInput id="department_id" :options="departments"
                v-model="form.department_id" type="text" class="mt-1 block w-3/4"
                ></SelectInput>
                <InputError :message="form.errors.department_id" class="mt-2"></InputError>
            </div>
            <div class="p-3 mt-6">
                <PrimaryButton :disabled="form.processing" @click="save">
                    <i class="fa-solid fa-save"></i> Salvar
                </PrimaryButton>
            </div>
            <div class="p-3 mt-6 flex justify-end">
                <SecondaryButton class="ml-3" :disabled="form.processing">
                    Cancelar
                </SecondaryButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
