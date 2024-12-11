<script setup>
import {computed} from "vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    name: {
        type: String,
        required: true
    },
    label: {
        type: String,
        required: true
    }
})

const sortClass = computed(() => {
    const urlParams = new URLSearchParams(window.location.search)
    let sortBy = urlParams.get('sort_by') || '';
    let sortDir = sortBy.charAt(0)

    return sortBy.replace(/^\-+/, "") === props.name ?
        (sortDir === '-' ? 'desc' : 'asc') : ''
})

const navigate = () => {
    const urlParams = new URLSearchParams(window.location.search)
    let sortBy = urlParams.get('sort_by') || ""
    let sortDir = sortBy.charAt(0)

    sortBy = !sortBy || sortDir === '-' ? props.name : `-${props.name}`
    urlParams.set('sort_by', sortBy)
    const params = Object.fromEntries(urlParams.entries())
    router.get(route(route().current()), params)
}
</script>

<template>
    <a href="#" @click.prevent="navigate" class="sortable" :class="sortClass">{{ props.label }}</a>
</template>

<style scoped>
th a {
    color: inherit;
}
th a:hover {
    text-decoration: none;
}
a.sortable {
    padding-right: 20px;
    position: relative;
}
a.sortable:before,
a.sortable:after {
    border: 4px solid transparent;
    content: "";
    display: block;
    height: 0;
    right: 5px;
    top: 50%;
    position: absolute;
    width: 0;
}
a.sortable:before {
    border-bottom-color: #e4e4e4;
    margin-top: -9px;
}
a.sortable.asc:before {
    border-bottom-color: #848484;
    margin-top: -9px;
}
a.sortable:after {
    border-top-color: #e4e4e4;
    margin-top: 1px;
}
a.sortable.desc:after {
    border-top-color: #848484;
    margin-top: 1px;
}
</style>
