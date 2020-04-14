import { BrowserModule } from '@angular/platform-browser';
import { NgModule,CUSTOM_ELEMENTS_SCHEMA, NO_ERRORS_SCHEMA } from '@angular/core';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { HomeComponent } from './home/home.component';
import { AlertComponent } from './alert/alert.component';
import { PostComponent } from './post/post.component';
import { MoviesComponent } from './movies/movies.component';
import { MatPaginator, MatSort, MatTableDataSource,MatButtonModule,MatInputModule, MatCardModule,MatChipsModule, MatMenuModule, MatToolbarModule, MatIconModule, MatSidenavModule, MatListModule, MatFormFieldModule, MatProgressSpinnerModule, MatProgressBarModule, MatGridListModule, MatPaginatorModule, MatSortModule, MatTableModule, MatSelectModule, MatSlideToggleModule, MatTabsModule } from '@angular/material';
import { ViewpostComponent } from './viewpost/viewpost.component';
import { SliderComponent } from './slider/slider.component';
import { SliderItemDirective } from './slider/slider-item.directive';
import { AdminComponent } from './Admin/admin/admin.component';
import { AuthenticationService } from './services/authentication.service';
import { AuthGuard } from './auth/auth.guard';
import { HeadersComponent } from './headers/headers.component';
import { AdminViewpostsComponent } from './Admin/admin-viewposts/admin-viewposts.component';
import { AdminViewusersComponent } from './Admin/admin-viewusers/admin-viewusers.component';
import { SliderImageComponent } from './slider-image/slider-image.component';
import { GalleryModule } from '@ngx-gallery/core';
import { LightboxModule } from '@ngx-gallery/lightbox';
import { GallerizeModule } from '@ngx-gallery/gallerize';

import {MatDialogModule, MatDialogRef, MAT_DIALOG_DATA} from '@angular/material/dialog';
import { UploadService } from './services/upload.service';

import { ThemeService } from './services/theme.service';
import { UserComponent } from './user/user.component';
import { UserContentComponent } from './user/user-content/user-content.component';
import { UserDetailsComponent } from './user/user-details/user-details.component';
import {FlexLayoutModule} from '@angular/flex-layout';
import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import { MatContenteditableModule } from 'mat-contenteditable';
//import { CKEditorModule } from '@ckeditor/ckeditor5-angular';
import { CKEditorModule } from 'ckeditor4-angular';
import { InfiniteScrollModule } from 'ngx-infinite-scroll';
import { NgxSpinnerModule } from "ngx-spinner";

import { FileService } from './services/file.service';
import { FileExplorerModule } from './file-explorer/file-explorer.module';
import { UploadModule } from './upload/upload.module';

import { ModalWindowComponent } from './modal-window/modal-window.component';
import { LogoComponent } from './headers/header-gadgets/logo/logo.component';
import { AccountComponent } from './headers/header-gadgets/account/account.component';
import { ContainerComponent } from './layout/container/container.component';
import { HeaderContainerComponent } from './headers/header-container/header-container.component';
import { HeaderNavbarComponent } from './headers/header-navbar/header-navbar.component';
import { HomeListComponent } from './home/home-list/home-list.component';
import { PostDetailsComponent } from './post/post-details/post-details.component';
import { CoreDetailsComponent } from './post/core-details/core-details.component';
import { ExploreModule } from './layout/explore/explore.module';
@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    RegisterComponent,
    HomeComponent,
    AlertComponent,
    PostComponent,
    MoviesComponent,
    ViewpostComponent,
    SliderComponent,
    SliderImageComponent,
    SliderItemDirective,
    AdminComponent,HeadersComponent, AdminViewpostsComponent, AdminViewusersComponent, UserComponent, UserContentComponent, UserDetailsComponent, ModalWindowComponent, LogoComponent, AccountComponent, ContainerComponent, HeaderContainerComponent, HeaderNavbarComponent, HomeListComponent, PostDetailsComponent, CoreDetailsComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule, // new modules added here
    MatToolbarModule,
    MatCardModule,
    MatFormFieldModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule,
    MatButtonModule,
    MatInputModule,
    MatChipsModule,    GalleryModule,
    LightboxModule,
    GallerizeModule,MatGridListModule,MatPaginatorModule, MatSortModule, MatTableModule,MatSelectModule,   MatSlideToggleModule,
    MatMenuModule,MatIconModule, MatSidenavModule, MatListModule,MatProgressSpinnerModule
    ,MatButtonModule, MatDialogModule, MatListModule, HttpClientModule, MatProgressBarModule,
    FlexLayoutModule,CKEditorModule,
    MatContenteditableModule,FontAwesomeModule,InfiniteScrollModule,NgxSpinnerModule,FileExplorerModule,ExploreModule
  ],
  entryComponents: [AdminViewusersComponent,HeadersComponent,HomeComponent,AdminComponent],
  providers: [{ provide: MatDialogRef, useValue: {} },{ provide: MAT_DIALOG_DATA, useValue: [] },AuthenticationService,AuthGuard,UploadService
              ,ThemeService ,FileService],
  bootstrap: [AppComponent],
  schemas: [ CUSTOM_ELEMENTS_SCHEMA ,NO_ERRORS_SCHEMA]
})
export class AppModule { }
