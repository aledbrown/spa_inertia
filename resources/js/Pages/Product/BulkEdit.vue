<script setup>
import Modal from "@/Components/Modal.vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    }
})
</script>

<template>
    <Modal :show="show" max-width="xl">
        <h3>Bulk Edit</h3>
    </Modal>
</template>
