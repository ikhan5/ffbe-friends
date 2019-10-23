import Home from './components/Units/Units'
import Profile from './components/User/Profile'
import AddUnit from './components/Units/AddUnit'

export const routes =[
    {path:'/', component: Home},
    {path: '/profile', component: Profile},
    {path: '/unit/add', component: AddUnit},
]