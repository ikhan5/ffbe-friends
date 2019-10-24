<template>
  <div class="mt-4">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a
          class="nav-link active"
          id="units-tab"
          data-toggle="tab"
          href="#units"
          role="tab"
          aria-controls="units"
          aria-selected="true"
        >Added Units</a>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div
        class="tab-pane fade show active mt-2"
        id="units"
        role="tabpanel"
        aria-labelledby="units-tab"
      >
        <table class="table table-responsive-md">
          <thead class="thead-light">
            <tr>
              <th scope="col" v-for="(column, index) in columns" :key="index">{{column}}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(unit,index) in units" :key="index">
              <th scope="row">{{unit.name}} {{unit.rarity}}&#x2605;</th>
              <td>
                <input class="form-control form-control-sm" type="text" :value="unit.atk" />
              </td>
              <td>
                <input class="form-control form-control-sm" type="text" :value="unit.mag" />
              </td>
              <td>
                <input class="form-control form-control-sm" type="text" :value="unit.def" />
              </td>
              <td>
                <input class="form-control form-control-sm" type="text" :value="unit.spr" />
              </td>
              <td>
                <input class="form-control form-control-sm" type="text" :value="unit.build" />
              </td>
              <td>
                <div class="row">
                  <button class="no-style text-danger mx-0 mx-auto">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="text-right col-md-12 mt-5">
      <button class="btn btn-primary" @click.prevent>Save Unit Changes</button>
    </div>
  </div>
</template>
<style scoped>
.no-style {
  background-color: white;
  border: solid 1px transparent;
  font-size: 1.1em;
}
</style>

<script>
export default {
  data() {
    return {
      columns: ["Name", "ATK", "MAG", "DEF", "SPR", "Build Link", "Actions"],
      link: "https://ffbeEquip.com/builder.html?server=GL#",
      units: []
    };
  }
};
// $("#myTab a").on("click", function(e) {
//   e.preventDefault();
//   $(this).tab("show");
// });
</script>