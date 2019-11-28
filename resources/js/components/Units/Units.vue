<template>
    <div>
        <h1 class="mb-4 mt-3">Unit Listings</h1>
        <div class="col-md-8 col-sm-12 mt-5 mb-3 mx-0 mx-auto">
            <input
                class="form-control"
                type="text"
                v-model="search"
                placeholder="Search Units or Usernames..."
                v-on:keydown.enter.prevent
            />
        </div>

        <b-button v-b-toggle.advancedSearch variant="btn btn-link"
            >+ Advanced Search</b-button
        >
        <b-collapse id="advancedSearch">
            <hr />
            <div class="row">
                <label class="col-md-2 col-sm-4 col-6"
                    ><input type="checkbox" v-model="toggleHeaders" /> Hide/Show
                    Columns</label
                >
                <label class="col-md-2 col-sm-4 col-6"
                    ><input type="checkbox" v-model="toggleStat" /> Stat
                    Restrictions</label
                >
                <label class="col-md-2 col-sm-4 col-6"
                    ><input type="checkbox" v-model="toggleElemental" />
                    Elemental Resists</label
                >
                <label class="col-md-2 col-sm-4 col-6"
                    ><input type="checkbox" v-model="toggleStatus" /> Status
                    Resists</label
                >
                <label class="col-md-2 col-sm-4 col-6"
                    ><input type="checkbox" v-model="togglePhysical" /> Physical
                    Killers</label
                >
                <label class="col-md-2 col-sm-4 col-6"
                    ><input type="checkbox" v-model="toggleMagical" /> Magical
                    Killers</label
                >
            </div>
            <hr />
            <div v-show="toggleHeaders">
                <p class="searchHeader">
                    Hide/Show Columns:
                </p>
                <div class="row">
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="profile"
                            type="checkbox"
                            @change="show_hide('profile')"
                            checked
                        />
                        Show Profile</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="element_weapon"
                            type="checkbox"
                            @change="show_hide('element_weapon')"
                            checked
                        />
                        Show Weapon Element</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="hp"
                            type="checkbox"
                            @change="show_hide('hp')"
                            checked
                        />
                        Show HP</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="mp"
                            type="checkbox"
                            @change="show_hide('mp')"
                            checked
                        />
                        Show MP</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="atk"
                            type="checkbox"
                            @change="show_hide('atk')"
                            checked
                        />
                        Show ATK</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="mag"
                            type="checkbox"
                            @change="show_hide('mag')"
                            checked
                        />
                        Show MAG</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="def"
                            type="checkbox"
                            @change="show_hide('def')"
                            checked
                        />
                        Show DEF</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="spr"
                            type="checkbox"
                            @change="show_hide('spr')"
                            checked
                        />
                        Show SPR</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="pevade"
                            type="checkbox"
                            @change="show_hide('pevade')"
                        />
                        Show Physical Evade</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="lb_damage"
                            type="checkbox"
                            @change="show_hide('lb_damage')"
                        />
                        Show LB Damage</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="physkillers"
                            type="checkbox"
                            @change="show_hide('physkillers')"
                        />
                        Show Physical Killers</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="magkillers"
                            type="checkbox"
                            @change="show_hide('magkillers')"
                        />
                        Show Magic Killers</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="status"
                            type="checkbox"
                            @change="show_hide('status')"
                        />
                        Show Status Resists</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="elemental"
                            type="checkbox"
                            @change="show_hide('elemental')"
                        />
                        Show Element Resists</label
                    >
                </div>
                <hr />
            </div>
            <div v-show="toggleStat">
                <p class="searchHeader">
                    Stat Restrictions:
                </p>
                <div class="row mt-2">
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-hp"
                            >HP greater than: {{ hpLimit }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-hp"
                            v-model.number="hpLimit"
                            type="range"
                            min="0"
                            step="1000"
                            max="30000"
                        ></b-form-input>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-mp"
                            >MP greater than: {{ mpLimit }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-mp"
                            v-model.number="mpLimit"
                            type="range"
                            min="0"
                            step="100"
                            max="1300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-atk"
                            >Attack greater than: {{ atkLimit }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-atk"
                            v-model.number="atkLimit"
                            type="range"
                            min="0"
                            step="250"
                            max="3500"
                        ></b-form-input>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-mag"
                            >Magic greater than: {{ magLimit }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-mag"
                            v-model.number="magLimit"
                            type="range"
                            min="0"
                            step="250"
                            max="3250"
                        ></b-form-input>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-def"
                            >Defense greater than: {{ defLimit }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-def"
                            v-model.number="defLimit"
                            type="range"
                            min="0"
                            step="250"
                            max="1750"
                        ></b-form-input>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-spr"
                            >Spirit greater than: {{ sprLimit }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-spr"
                            v-model.number="sprLimit"
                            type="range"
                            min="0"
                            step="250"
                            max="2500"
                        ></b-form-input>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-limit"
                            >LB greater than: {{ lbLimit }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-limit"
                            v-model.number="lbLimit"
                            type="range"
                            min="0"
                            step="50"
                            max="200"
                        ></b-form-input>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-limit"
                            >Evade greater than: {{ evadeLimit }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-limit"
                            v-model.number="evadeLimit"
                            type="range"
                            min="0"
                            step="25"
                            max="100"
                        ></b-form-input>
                    </div>
                </div>
                <hr />
            </div>
            <div v-show="toggleElemental">
                <p class="searchHeader">
                    Elemental Resistance (Greater or Equal To):
                </p>
                <div class="row mt-2">
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-fire"
                            >Fire Resist: {{ elementalLimits.fire }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-fire"
                            v-model.number="elementalLimits.fire"
                            type="range"
                            min="0"
                            step="10"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-ice"
                            >Ice Resist: {{ elementalLimits.ice }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-ice"
                            v-model.number="elementalLimits.ice"
                            type="range"
                            min="0"
                            step="10"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-lightning"
                            >Lightning Resist:
                            {{ elementalLimits.lightning }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-lightning"
                            v-model.number="elementalLimits.lightning"
                            type="range"
                            min="0"
                            step="10"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-water"
                            >Water Resist: {{ elementalLimits.water }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-water"
                            v-model.number="elementalLimits.water"
                            type="range"
                            min="0"
                            step="10"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-wind"
                            >Wind Resist: {{ elementalLimits.wind }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-wind"
                            v-model.number="elementalLimits.wind"
                            type="range"
                            min="0"
                            step="10"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-earth"
                            >Earth Resist: {{ elementalLimits.earth }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-earth"
                            v-model.number="elementalLimits.earth"
                            type="range"
                            min="0"
                            step="10"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-light"
                            >Light Resist: {{ elementalLimits.light }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-light"
                            v-model.number="elementalLimits.light"
                            type="range"
                            min="0"
                            step="10"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-dark"
                            >Dark Resist: {{ elementalLimits.dark }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-dark"
                            v-model.number="elementalLimits.dark"
                            type="range"
                            min="0"
                            step="10"
                            max="300"
                        ></b-form-input>
                    </div>
                </div>
                <hr />
            </div>
            <div v-show="toggleStatus">
                <p class="searchHeader">
                    Status Resists (100%):
                </p>
                <div class="row mt-2">
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="status"
                            type="checkbox"
                            v-model="ribbonCheck"
                        />
                        Ribbon</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="status"
                            type="checkbox"
                            v-model="deathCheck"
                        />
                        Death</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="status"
                            type="checkbox"
                            v-model="charmCheck"
                        />
                        Charm</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="status"
                            type="checkbox"
                            v-model="stopCheck"
                        />
                        Stop</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="status"
                            type="checkbox"
                            v-model="poisonCheck"
                        />
                        Poison</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="status"
                            type="checkbox"
                            v-model="blindCheck"
                        />
                        Blind</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="status"
                            type="checkbox"
                            v-model="sleepCheck"
                        />
                        Sleep</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="status"
                            type="checkbox"
                            v-model="paralyzeCheck"
                        />
                        Paralyze</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="status"
                            type="checkbox"
                            v-model="silenceCheck"
                        />
                        Silence</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="status"
                            type="checkbox"
                            v-model="confusionCheck"
                        />
                        Confusion</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="status"
                            type="checkbox"
                            v-model="diseaseCheck"
                        />
                        Disease</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="status"
                            type="checkbox"
                            v-model="stoneCheck"
                        />
                        Stone</label
                    >
                </div>
                <hr />
            </div>
            <div v-show="togglePhysical">
                <p class="searchHeader">
                    Physical Killers (Greater or Equal To):
                </p>

                <div class="row mt-2">
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-physAqua"
                            >Aquatic Killer:
                            {{ physKillerLimits.aquatic }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-physAqua"
                            v-model.number="physKillerLimits.aquatic"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-physBeast"
                            >Beast Killer: {{ physKillerLimits.beast }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-physBeast"
                            v-model.number="physKillerLimits.beast"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-physBird"
                            >Bird Killer: {{ physKillerLimits.bird }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-physBird"
                            v-model.number="physKillerLimits.bird"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-physBug"
                            >Bug Killer: {{ physKillerLimits.bug }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-physBug"
                            v-model.number="physKillerLimits.bug"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-physDemon"
                            >Demon Killer: {{ physKillerLimits.demon }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-physDemon"
                            v-model.number="physKillerLimits.demon"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-physDragon"
                            >Dragon Killer: {{ physKillerLimits.dragon }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-physDragon"
                            v-model.number="physKillerLimits.dragon"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-physHuman"
                            >Human Killer: {{ physKillerLimits.human }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-physHuman"
                            v-model.number="physKillerLimits.human"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-physMachine"
                            >Machine Killer:
                            {{ physKillerLimits.machine }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-physMachine"
                            v-model.number="physKillerLimits.machine"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-physPlant"
                            >Plant Killer: {{ physKillerLimits.plant }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-physPlant"
                            v-model.number="physKillerLimits.plant"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-physUndead"
                            >Undead Killer: {{ physKillerLimits.undead }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-physUndead"
                            v-model.number="physKillerLimits.undead"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-phyStone"
                            >Stone Killer: {{ physKillerLimits.stone }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-phyStone"
                            v-model.number="physKillerLimits.stone"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-physSpirit"
                            >Spirit Killer: {{ physKillerLimits.spirit }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-physSpirit"
                            v-model.number="physKillerLimits.spirit"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                </div>

                <hr />
            </div>
            <div v-show="toggleMagical">
                <p class="searchHeader">
                    Magical Killers (Greater or Equal To):
                </p>

                <div class="row mt-2">
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-magAquatic"
                            >Aquatic Killer:
                            {{ magKillerLimits.aquatic }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-magAquatic"
                            v-model.number="magKillerLimits.aquatic"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-magBeast"
                            >Beast Killer: {{ magKillerLimits.beast }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-magBeast"
                            v-model.number="magKillerLimits.beast"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-magBird"
                            >Bird Killer: {{ magKillerLimits.bird }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-magBird"
                            v-model.number="magKillerLimits.bird"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-magBug"
                            >Bug Killer: {{ magKillerLimits.bug }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-magBug"
                            v-model.number="magKillerLimits.bug"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-magDemon"
                            >Demon Killer: {{ magKillerLimits.demon }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-magDemon"
                            v-model.number="magKillerLimits.demon"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-magDragon"
                            >Dragon Killer: {{ magKillerLimits.dragon }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-magDragon"
                            v-model.number="magKillerLimits.dragon"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-magDemon"
                            >Human Killer: {{ magKillerLimits.human }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-magDemon"
                            v-model.number="magKillerLimits.human"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-magMachine"
                            >Machine Killer:
                            {{ magKillerLimits.machine }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-magMachine"
                            v-model.number="magKillerLimits.machine"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-magPlant"
                            >Plant Killer: {{ magKillerLimits.plant }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-magPlant"
                            v-model.number="magKillerLimits.plant"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-magPlant"
                            >Undead Killer: {{ magKillerLimits.undead }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-magPlant"
                            v-model.number="magKillerLimits.undead"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-magStone"
                            >Stone Killer: {{ magKillerLimits.stone }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-magStone"
                            v-model.number="magKillerLimits.stone"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <label for="range-magSpirit"
                            >Spirit Killer: {{ magKillerLimits.spirit }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-magSpirit"
                            v-model.number="magKillerLimits.spirit"
                            type="range"
                            min="0"
                            step="25"
                            max="300"
                        ></b-form-input>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="mx-auto mx-0">
                    <b-button v-b-toggle.advancedSearch variant="btn btn-link"
                        >Close Search</b-button
                    >
                    <button
                        class="btn btn-outline-danger"
                        @click="resetFilters"
                    >
                        Reset Filters
                    </button>
                </div>
            </div>
            <hr />
        </b-collapse>
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
                    <template
                        v-for="(killers, key, index) in data.item.magkillers"
                    >
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
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
export default {
    data() {
        return {
            perPage: 5,
            currentPage: 1,
            search: "",
            toggleHeaders: true,
            toggleStat: false,
            toggleStatus: false,
            togglePhysical: false,
            toggleMagical: false,
            toggleElemental: false,
            hpLimit: 0,
            mpLimit: 0,
            atkLimit: 0,
            defLimit: 0,
            magLimit: 0,
            sprLimit: 0,
            lbLimit: 0,
            evadeLimit: 0,
            physKillerLimits: {
                aquatic: 0,
                beast: 0,
                bird: 0,
                bug: 0,
                demon: 0,
                dragon: 0,
                human: 0,
                machine: 0,
                plant: 0,
                undead: 0,
                stone: 0,
                spirit: 0
            },
            magKillerLimits: {
                aquatic: 0,
                beast: 0,
                bird: 0,
                bug: 0,
                demon: 0,
                dragon: 0,
                human: 0,
                machine: 0,
                plant: 0,
                undead: 0,
                stone: 0,
                spirit: 0
            },
            elementalLimits: {
                fire: 0,
                ice: 0,
                lightning: 0,
                water: 0,
                wind: 0,
                earth: 0,
                light: 0,
                dark: 0
            },
            ribbonCheck: false,
            stopCheck: false,
            charmCheck: false,
            deathCheck: false,
            poisonCheck: false,
            blindCheck: false,
            sleepCheck: false,
            paralyzeCheck: false,
            silenceCheck: false,
            confusionCheck: false,
            diseaseCheck: false,
            stoneCheck: false,
            fields: [
                {
                    key: "name",
                    label: "Unit Name",
                    sortable: true
                },
                {
                    key: "profile",
                    label: "Profile",
                    sortable: false,
                    thClass: "",
                    tdClass: ""
                },
                {
                    key: "element_weapon",
                    label: "Element(s)",
                    sortable: true,
                    thClass: "",
                    tdClass: ""
                },
                {
                    key: "hp",
                    label: "HP",
                    sortable: true,
                    thClass: "",
                    tdClass: ""
                },
                {
                    key: "mp",
                    label: "MP",
                    sortable: true,
                    thClass: "",
                    tdClass: ""
                },
                {
                    key: "atk",
                    label: "ATK",
                    sortable: true,
                    thClass: "",
                    tdClass: ""
                },
                {
                    key: "mag",
                    label: "MAG",
                    sortable: true,
                    thClass: "",
                    tdClass: ""
                },
                {
                    key: "def",
                    label: "DEF",
                    sortable: true,
                    thClass: "",
                    tdClass: ""
                },
                {
                    key: "spr",
                    label: "SPR",
                    sortable: true,
                    thClass: "",
                    tdClass: ""
                },
                {
                    key: "pevade",
                    label: "P.Evade",
                    sortable: true,
                    thClass: "d-none",
                    tdClass: "d-none",
                    defaultCol: false
                },
                {
                    key: "lb_damage",
                    label: "LB",
                    sortable: true,
                    thClass: "d-none",
                    tdClass: "d-none",
                    defaultCol: false
                },
                {
                    key: "magkillers",
                    label: "M.Killers",
                    sortable: false,
                    thClass: "d-none",
                    tdClass: "d-none",
                    defaultCol: false
                },
                {
                    key: "physkillers",
                    label: "P.Killers",
                    sortable: false,
                    thClass: "d-none",
                    tdClass: "d-none",
                    defaultCol: false
                },
                {
                    key: "status",
                    label: "Status",
                    sortable: false,
                    thClass: "d-none",
                    tdClass: "d-none",
                    defaultCol: false
                },
                {
                    key: "elemental",
                    label: "Elemental",
                    sortable: false,
                    thClass: "d-none",
                    tdClass: "d-none",
                    defaultCol: false
                }
            ],
            link: "https://ffbeEquip.com/builder.html?server=GL#",
            units: [],
            isLoading: true
        };
    },
    beforeCreate() {
        this.isLoading = true;
    },
    created() {
        axios
            .get("/api/units")
            .then(res => {
                this.isLoading = false;
                this.units = res.data;
            })
            .catch(err => {
                Swal.fire(
                    "Error, Kupo!",
                    "There was an error whilst loading the units, please try again later",
                    "error"
                );
            });
    },
    computed: {
        filterUnits() {
            return this.units.filter(unit => {
                //search filters
                let unitName = unit.name
                    .toLowerCase()
                    .match(this.search.toLowerCase());
                let inGameName = unit.profile.ign
                    .toLowerCase()
                    .match(this.search.toLowerCase());

                //stat filters
                let attackLimit = unit.atk >= this.atkLimit;
                let magicLimit = unit.mag >= this.magLimit;
                let defenseLimit = unit.def >= this.defLimit;
                let spiritLimit = unit.spr >= this.sprLimit;
                let healthLimit = unit.hp >= this.hpLimit;
                let manaLimit = unit.mp >= this.mpLimit;
                let limitLimit = unit.lb_damage >= this.lbLimit;
                let evadeLimit = unit.pevade >= this.evadeLimit;

                //status filters
                let stop = unit.status.stop >= 100;
                let charm = unit.status.charm >= 100;
                let death = unit.status.death >= 100;
                let poison = unit.status.poison >= 100;
                let blind = unit.status.blind >= 100;
                let sleep = unit.status.sleep >= 100;
                let paralyze = unit.status.paralyze >= 100;
                let silence = unit.status.silence >= 100;
                let confusion = unit.status.confusion >= 100;
                let disease = unit.status.disease >= 100;
                let stone = unit.status.stone >= 100;
                let ribbon =
                    poison &&
                    blind &&
                    sleep &&
                    paralyze &&
                    silence &&
                    confusion &&
                    disease;

                //physical killer filters
                let phys_aquatic =
                    unit.physkillers.aquatic >= this.physKillerLimits.aquatic;
                let phys_beast =
                    unit.physkillers.beast >= this.physKillerLimits.beast;
                let phys_bird =
                    unit.physkillers.bird >= this.physKillerLimits.bird;
                let phys_bug =
                    unit.physkillers.bug >= this.physKillerLimits.bug;
                let phys_demon =
                    unit.physkillers.demon >= this.physKillerLimits.demon;
                let phys_dragon =
                    unit.physkillers.dragon >= this.physKillerLimits.dragon;
                let phys_human =
                    unit.physkillers.human >= this.physKillerLimits.human;
                let phys_machine =
                    unit.physkillers.machine >= this.physKillerLimits.machine;
                let phys_plant =
                    unit.physkillers.plant >= this.physKillerLimits.plant;
                let phys_undead =
                    unit.physkillers.undead >= this.physKillerLimits.undead;
                let phys_stone =
                    unit.physkillers.stone >= this.physKillerLimits.stone;
                let phys_spirit =
                    unit.physkillers.spirit >= this.physKillerLimits.spirit;

                //magica killers filters
                let mag_aquatic =
                    unit.magkillers.aquatic >= this.magKillerLimits.aquatic;
                let mag_beast =
                    unit.magkillers.beast >= this.magKillerLimits.beast;
                let mag_bird =
                    unit.magkillers.bird >= this.magKillerLimits.bird;
                let mag_bug = unit.magkillers.bug >= this.magKillerLimits.bug;
                let mag_demon =
                    unit.magkillers.demon >= this.magKillerLimits.demon;
                let mag_dragon =
                    unit.magkillers.dragon >= this.magKillerLimits.dragon;
                let mag_human =
                    unit.magkillers.human >= this.magKillerLimits.human;
                let mag_machine =
                    unit.magkillers.machine >= this.magKillerLimits.machine;
                let mag_plant =
                    unit.magkillers.plant >= this.magKillerLimits.plant;
                let mag_undead =
                    unit.magkillers.undead >= this.magKillerLimits.undead;
                let mag_stone =
                    unit.magkillers.stone >= this.magKillerLimits.stone;
                let mag_spirit =
                    unit.magkillers.spirit >= this.magKillerLimits.spirit;

                //elemental filters
                let fire = unit.elemental.fire >= this.elementalLimits.fire;
                let ice = unit.elemental.ice >= this.elementalLimits.ice;
                let lightning =
                    unit.elemental.lightning >= this.elementalLimits.lightning;
                let water = unit.elemental.water >= this.elementalLimits.water;
                let wind = unit.elemental.wind >= this.elementalLimits.wind;
                let earth = unit.elemental.earth >= this.elementalLimits.earth;
                let light = unit.elemental.light >= this.elementalLimits.light;
                let dark = unit.elemental.dark >= this.elementalLimits.dark;

                return (
                    (unitName || inGameName) &&
                    attackLimit &&
                    magicLimit &&
                    defenseLimit &&
                    spiritLimit &&
                    healthLimit &&
                    manaLimit &&
                    evadeLimit &&
                    limitLimit &&
                    phys_aquatic &&
                    phys_beast &&
                    phys_bird &&
                    phys_bug &&
                    phys_demon &&
                    phys_dragon &&
                    phys_human &&
                    phys_machine &&
                    phys_plant &&
                    phys_undead &&
                    phys_stone &&
                    phys_spirit &&
                    mag_aquatic &&
                    mag_beast &&
                    mag_bird &&
                    mag_bug &&
                    mag_demon &&
                    mag_dragon &&
                    mag_human &&
                    mag_machine &&
                    mag_plant &&
                    mag_undead &&
                    mag_stone &&
                    mag_spirit &&
                    fire &&
                    ice &&
                    lightning &&
                    water &&
                    wind &&
                    earth &&
                    light &&
                    dark &&
                    (ribbon || !this.ribbonCheck) &&
                    (stop || !this.stopCheck) &&
                    (charm || !this.charmCheck) &&
                    (death || !this.deathCheck) &&
                    (poison || !this.poisonCheck) &&
                    (blind || !this.blindCheck) &&
                    (sleep || !this.sleepCheck) &&
                    (paralyze || !this.paralyzeCheck) &&
                    (silence || !this.silenceCheck) &&
                    (confusion || !this.confusionCheck) &&
                    (disease || !this.diseaseCheck) &&
                    (stone || !this.stoneCheck)
                );
            });
        },
        rows() {
            return this.filterUnits.length;
        }
    },
    methods: {
        show_hide(colName) {
            this.fields.filter(col => {
                if (col.key === colName) {
                    if (col.thClass === "" && col.tdClass === "") {
                        col.thClass = "d-none";
                        col.tdClass = "d-none";
                    } else {
                        col.thClass = "";
                        col.tdClass = "";
                    }
                }
            });
        },
        resetFilters() {
            this.fields.forEach(col => {
                if (col.defaultCol === false) {
                    document.querySelector("." + col.key).checked = false;
                    col.thClass = "d-none";
                    col.tdClass = "d-none";
                } else {
                    if (col.key !== "name") {
                        document.querySelector("." + col.key).checked = true;
                        col.thClass = "";
                        col.tdClass = "";
                    }
                }
            });

            //reset stat filters
            this.hpLimit = 0;
            this.mpLimit = 0;
            this.atkLimit = 0;
            this.defLimit = 0;
            this.magLimit = 0;
            this.sprLimit = 0;
            this.lbLimit = 0;
            this.evadeLimit = 0;

            //reset elemental filters
            this.elementalLimits.fire = 0;
            this.elementalLimits.ice = 0;
            this.elementalLimits.lightning = 0;
            this.elementalLimits.water = 0;
            this.elementalLimits.wind = 0;
            this.elementalLimits.earth = 0;
            this.elementalLimits.light = 0;
            this.elementalLimits.dark = 0;

            //reset physical killers
            Object.keys(this.physKillerLimits).forEach(key => {
                this.physKillerLimits[key] = 0;
            });

            //reset magical killers
            Object.keys(this.magKillerLimits).forEach(key => {
                this.magKillerLimits[key] = 0;
            });

            //reset status filters
            this.poisonCheck = false;
            this.blindCheck = false;
            this.sleepCheck = false;
            this.paralyzeCheck = false;
            this.silenceCheck = false;
            this.confusionCheck = false;
            this.diseaseCheck = false;
            this.ribbonCheck = false;
            this.deathCheck = false;
            this.charmCheck = false;
            this.stopCheck = false;
            this.stoneCheck = false;
        }
    }
};
</script>

<style scoped>
div {
    margin-top: 10px;
}

h1 {
    margin-bottom: 30px;
}

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

.searchHeader {
    font-weight: bold;
}
</style>
