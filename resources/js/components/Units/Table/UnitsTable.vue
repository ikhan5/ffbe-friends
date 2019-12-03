<template>
    <b-table
        id="unitsTable"
        :items="filterUnits"
        :fields="fields"
        :busy="isLoading"
        :per-page="perPage"
        :current-page="currentPage"
        responsive
        show-empty
        caption-top
    >
        <template v-slot:table-caption
            >Login/Register to start adding Units</template
        >
        <template v-slot:cell(name)="data">
            <p>
                <a target="_blank" :href="link + data.item.build"
                    >{{ data.item.name }} {{ data.item.rarity }}&#x2605;
                </a>
            </p>
            <p>Slot: {{ data.item.slot }}</p>
        </template>

        <template v-slot:cell(profile)="data">
            <p class="mb-0">
                {{ data.item.profile.ign }}: <br />
                {{ data.item.profile.friendCode | friendCode }}
            </p>

            <span class="mb-0">
                <p class="mb-0" v-if="data.item.profile.reddit">
                    {{ data.item.profile.reddit | reddit }}
                </p>
                <p v-if="data.item.profile.discord">
                    {{ data.item.profile.discord }}
                </p>
            </span>
        </template>

        <template v-slot:empty="scope">
            <h4>{{ scope.emptyText }}</h4>
        </template>

        <template v-slot:empty="scope">
            <h4>{{ scope.emptyFilteredText }}</h4>
        </template>

        <template v-slot:cell(element_weapon)="data">
            <p>
                {{
                    data.item.element_weapon === "" ||
                    data.item.element_weapon === "Elementless"
                        ? "No Element"
                        : data.item.element_weapon
                }}
            </p>
        </template>

        <template v-slot:cell(pevade)="data">
            {{ data.item.pevade }}%
        </template>

        <template v-slot:cell(lb_damage)="data">
            {{ data.item.lb_damage === "" ? 0 : data.item.lb_damage }}%
        </template>

        <template v-slot:cell(magkillers)="data">
            <ul>
                <template v-for="(killers, key, index) in data.item.magkillers">
                    <li v-if="killers != 0" :key="'mag' + index">
                        {{ key | capitalize }}: {{ killers }}%
                    </li>
                </template>
            </ul>
        </template>
        <template v-slot:cell(physkillers)="data">
            <ul>
                <template
                    v-for="(killers, key, index) in data.item.physkillers"
                >
                    <li v-if="killers != 0" :key="'phys' + index">
                        {{ key | capitalize }}: {{ killers }}%
                    </li>
                </template>
            </ul>
        </template>

        <template v-slot:cell(status)="data">
            <ul>
                <template v-for="(status, key, index) in data.item.status">
                    <li v-if="status != 0" :key="'status' + index">
                        {{ key | capitalize }}:
                        {{ status > 100 ? 100 : status }}%
                    </li>
                </template>
            </ul>
        </template>
        <template v-slot:cell(elemental)="data">
            <ul>
                <template
                    v-for="(elemental, key, index) in data.item.elemental"
                >
                    <li v-if="elemental != 0" :key="'elem' + index">
                        {{ key | capitalize }}: {{ elemental }}%
                    </li>
                </template>
            </ul>
        </template>
        <template v-slot:table-busy>
            <div class="text-center text-danger my-2">
                <b-spinner class="align-middle"></b-spinner>
                <strong>Loading...</strong>
            </div>
        </template>
    </b-table>
</template>

<script>
export default {
    props: [
        "link",
        "filterUnits",
        "fields",
        "isLoading",
        "perPage",
        "currentPage"
    ]
};
</script>

<style scoped>
ul {
    list-style-type: none;
    padding-left: 0;
}

li {
    margin-bottom: 5px;
    font-size: 0.95em;
}

.killers {
    width: 120px;
}
</style>
