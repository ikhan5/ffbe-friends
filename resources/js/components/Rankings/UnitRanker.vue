<template>
    <div>
        <h1 class="row mt-3">2019 Unit Ranker</h1>
        <hr />
        <div class="row ml-1">
            <div class="form-check form-check-inline">
                <input
                    class="form-check-input"
                    type="radio"
                    v-model="rankType"
                    id="overallRank"
                    value="overallRank"
                />
                <label class="form-check-label" for="overallRank"
                    >Top 15 Ranking</label
                >
            </div>
            <div class="form-check form-check-inline">
                <input
                    class="form-check-input"
                    type="radio"
                    v-model="rankType"
                    id="results"
                    value="results"
                />
                <label class="form-check-label" for="results">Results</label>
            </div>
        </div>
        <hr />
        <keep-alive v-if="rankType === 'overallRank'">
            <app-overall-rank></app-overall-rank>
        </keep-alive>
        <keep-alive v-else-if="rankType === 'results'">
            <app-results></app-results>
        </keep-alive>
    </div>
</template>

<script>
import OverallRank from "./Overall";
import RoleRank from "./Role";
import Results from "./Results";
export default {
    data() {
        return {
            rankType: "overallRank"
        };
    },
    components: {
        "app-overall-rank": OverallRank,
        "app-results": Results
    }
};
</script>
