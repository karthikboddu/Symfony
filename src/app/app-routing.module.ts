import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';
import { HomeComponent } from './home/home.component';
import { PostComponent } from './post/post.component';
import { MoviesComponent } from './movies/movies.component';
import {ViewpostComponent} from './viewpost/viewpost.component';
import { AdminComponent } from './Admin/admin/admin.component';
import {AuthGuard} from './auth/auth.guard';
import {AdminGuard} from './auth/admin.guard';
import { AdminViewusersComponent } from './Admin/admin-viewusers/admin-viewusers.component';
const routes: Routes = [
  { path: 'login', component: LoginComponent },
  { path: 'register', component: RegisterComponent },
  { path: 'post', component: PostComponent },
  { path:'home',component:HomeComponent},
  { path:'home/:id',component:HomeComponent},
  { path:'movies',component:MoviesComponent},
  { path:'viewpost',component:ViewpostComponent},
  { path:'viewpost/:id',component:ViewpostComponent},
  {
    path: 'admin',
    canActivate: [
      AuthGuard,AdminGuard
    ],
    children: [
      {
        path: '',
        component: AdminComponent
      },
      {
        path :'users',
        component : AdminViewusersComponent
      },
      {
        path :'posts',
        component : AdminViewusersComponent
      }
    ]
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
  providers : [AuthGuard,AdminGuard]
})
export class AppRoutingModule { }
