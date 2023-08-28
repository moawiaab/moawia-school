<template>
    <div class="col q-ma-sm">
        <q-card flat variant="tonal" :class="`q-pa-sm bg-${color}-1`">
            <div class="row">
                <div class="col q-pa-xs">
                    <q-item-label :class="`q-mb-2 text-${color} text-bold `">
                        {{ title }}
                    </q-item-label>
                    <q-separator :color="color" />
                    <!-- <v-list-item-title class="mb-1"> {{title}} </v-list-item-title> -->
                    <q-item-label :class="`text-${color} text-bold`">

                        {{ text }}
                        <sub
                            ><small class="text-subtitle-2">{{
                                subTitle
                            }}</small></sub
                        >
                        </q-item-label
                    >
                </div>
                <q-separator vertical :color="color" />
                <div class="col text-center">
                    <q-icon :name="icon" size="xl" tag="span" :color="color" />
                </div>
            </div>
        </q-card>
    </div>
</template>

<script lang="ts">
export default {
    name: "ShowCard",
    props: ["title", "icon", "text", "color", "subTitle"],
};
</script>
