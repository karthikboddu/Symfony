import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
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
import { MatButtonModule,MatInputModule, MatCardModule,MatChipsModule, MatMenuModule, MatToolbarModule, MatIconModule, MatSidenavModule, MatListModule, MatFormFieldModule, MatProgressSpinnerModule } from '@angular/material';
import { ViewpostComponent } from './viewpost/viewpost.component';
import { SliderComponent } from './slider/slider.component';
import { SliderItemDirective } from './slider/slider-item.directive';
import { AdminComponent } from './Admin/admin/admin.component';
import { AuthenticationService } from './services/authentication.service';
import { AuthGuard } from './auth/auth.guard';
import { SliderImageComponent } from './slider-image/slider-image.component';
import { HeadersComponent } from './headers/headers.component';
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
    SliderItemDirective,
    AdminComponent,
    SliderImageComponent,
    HeadersComponent
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
    MatChipsModule,
    MatMenuModule,MatIconModule, MatSidenavModule, MatListModule,MatProgressSpinnerModule
  ],
  providers: [AuthenticationService,AuthGuard],
  bootstrap: [AppComponent]
})
export class AppModule { }
