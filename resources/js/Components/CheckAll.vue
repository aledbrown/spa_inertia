<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import {computed} from "vue";

const props = defineProps({
    rows: {
        type: Array,
        required: true
    },
    modelValue: {
        type: Array,
        required: true
    }
});

const emit = defineEmits(['update:modelValue']);

const proxyChecked = computed({
    get() {
        return props.modelValue.length === props.rows.length;
    },
    set(value) {
        const checked = []
        if (value) {
            props.rows.forEach(row => {
                checked.push(row.id)
            })
        }
        emit('update:modelValue', checked);
    }
})
</script>

<template>
    <Checkbox v-model:checked="proxyChecked" />
</template>
