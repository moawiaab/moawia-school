<template>
    <q-item clickable :to="data.to">
        <q-item-section avatar>
            <q-icon :name="data.icon || 'explore'" />
        </q-item-section>

        <q-item-section>
            {{ data.text }}
        </q-item-section>
    </q-item>
</template>

<script>
export default {
    props: ["data"],
    setup() {},
};
</script>

<style></style>
