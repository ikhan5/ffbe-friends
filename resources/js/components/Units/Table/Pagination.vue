<template>
    <div class="d-md-flex float-right mb-4">
        <b-pagination
            v-model="currentPage"
            :total-rows="rows"
            :per-page="perPage"
            aria-controls="unitsTable"
            first-text="First"
            prev-text="Prev"
            next-text="Next"
            last-text="Last"
        ></b-pagination>
    </div>
</template>

<script>
export default {
    props: ["currentPage", "rows", "perPage"]
};
</script>
