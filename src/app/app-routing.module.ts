import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';
import { HomeComponent } from './home/home.component';
import { PostComponent } from './post/post.component';
import { MoviesComponent } from './movies/movies.component';
import { ViewpostComponent } from './viewpost/viewpost.component';
import { AdminComponent } from './Admin/admin/admin.component';
import { AuthGuard } from './auth/auth.guard';
import { AdminGuard } from './auth/admin.guard';
import { AdminViewusersComponent } from './Admin/admin-viewusers/admin-viewusers.component';
import { AlertComponent } from './alert/alert.component';
import { AdminViewpostsComponent } from './Admin/admin-viewposts/admin-viewposts.component';
import { UploadDialogComponent } from './upload/upload-dialog/upload-dialog.component';
import {UploadComponent} from './upload/upload.component';
import { UserComponent } from './user/user.component';
import { UserDetailsComponent } from './user/user-details/user-details.component';
import { UserContentComponent } from './user/user-content/user-content.component';
import { AppComponent } from './app.component';
import { ModalWindowComponent } from './modal-window/modal-window.component';
const routes: Routes = [
 
  { path: 'register', component: RegisterComponent },
  { path: 'post', component: PostComponent,canActivate:[AuthGuard] },
  { path: 'home', component: HomeComponent },
  { path: 'home/:id', component: HomeComponent,canActivate:[AuthGuard] },
  { path: 'movies', component: MoviesComponent,canActivate:[AuthGuard] },
  { path: 'viewpost', component: ViewpostComponent,canActivate:[AuthGuard] },
  { path: 'viewpost/:id', component: ViewpostComponent,canActivate:[AuthGuard] },
  {
    path: 'explore2',
    loadChildren: () => import('./file-explorer/file-explorer.module').then(m => m.FileExplorerModule)
  },

  { path :'users',
    canActivate:[AuthGuard],
    children:[{
      path : '',
      component : UserComponent
      },
      {
        path : 'user-details',
        component : UserDetailsComponent,
      },
      {
        path : 'user-content',
        component : UserContentComponent
      }
    ]
  },
  {
    path: 'admin',
    canActivate: [
      AuthGuard, AdminGuard
    ],
    children: [
      {
        path: '',
        component: AdminComponent
      },
      {
        path: 'users',
        component: AdminViewusersComponent
      },
      {
        path: 'allposts',
        component: AdminViewpostsComponent
      }
    ]
  },
  { path: 'upload', component: UploadComponent },
  {
    path: 'login',
    outlet: 'modal',
    component: ModalWindowComponent,
    data: {
      hideCloseText: true
    },
    children: [
      {
        path: '',
        component: LoginComponent
      }
    ]
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
  providers: [AuthGuard, AdminGuard]
})
export class AppRoutingModule { }
