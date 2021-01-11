const widget = {
  template: `
  <v-card active-class="default-class widget-card">
    <v-card-text class="pa-0">
      <v-container class="pa-0">
        <div class="layout row ma-0" :style="{ backgroundColor: color }">
          <div class="layout column ma-0 justify-center" style="color: white;">
          
            <span v-if="supTitle !==undefined" class="caption">{{ supTitle }}</span><span v-else class="headline">&nbsp;</span>
            <div v-if="title !==undefined" class="caption">{{ title }}</div><div v-else class="caption">&nbsp;</div>
            <span v-if="subTitle !==undefined" class="caption">{{ subTitle }}</span><span v-else class="caption">&nbsp;</span>
          </div>
        </div>
      </v-container>
    </v-card-text>
  </v-card>
`,
  props: {
    supTitle: {
      type: String,
      required: false
    },
    subTitle: {
      type: String,
      required: false
    },
    title: {
      type: String,
      required: false
    },
    icon: {
      type: String,
      required: false
    },
    color: {
      type: String,
      required: false
    }
  },

  data() {
    return {}
  },
  style: `
.widget-card {
border-radius: 5%;font-size:40px;
box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.21);
background-color: transparent;
margin-left: 10px;
}`
}
Vue.component('widget', widget)
