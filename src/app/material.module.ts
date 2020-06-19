import {NgModule} from "@angular/core";
import { CommonModule } from '@angular/common';
import { LayoutModule } from '@angular/cdk/layout';

import { MatButtonModule } from '@angular/material/button';
import { MatCardModule } from '@angular/material/card';
import { MatCheckboxModule } from '@angular/material/checkbox';
import { MatChipsModule } from '@angular/material/chips';
import { MatNativeDateModule } from '@angular/material/core';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatDialogModule } from '@angular/material/dialog';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatGridListModule } from '@angular/material/grid-list';
import { MatIconModule } from '@angular/material/icon';
import { MatInputModule } from '@angular/material/input';
import { MatListModule } from '@angular/material/list';
import { MatMenuModule } from '@angular/material/menu';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatSelectModule } from '@angular/material/select';
import { MatSidenavModule } from '@angular/material/sidenav';
import { MatSnackBarModule } from '@angular/material/snack-bar';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatTooltipModule } from '@angular/material/tooltip';
import { MatSort, MatSortModule } from '@angular/material/sort';
import { MatTableDataSource, MatTableModule } from '@angular/material/table';
import { MatContenteditableModule } from 'mat-contenteditable';
import { MatTabsModule } from '@angular/material/tabs';
import { MatPaginator, MatPaginatorModule } from '@angular/material/paginator';
@NgModule({
  imports: [
  CommonModule, 
  LayoutModule,
  MatToolbarModule,
  MatButtonModule, 
  MatCardModule,
  MatInputModule,
  MatDialogModule,
  MatTableModule,
  MatSortModule,
  MatTabsModule,
  MatContenteditableModule,
  MatMenuModule,
  MatIconModule,
  MatSelectModule,
  MatProgressSpinnerModule,
  MatFormFieldModule,
  MatSidenavModule,
  MatGridListModule,
  MatListModule,
  MatChipsModule,
  MatDatepickerModule,
  MatNativeDateModule,MatSnackBarModule
  ,MatTooltipModule,
  MatCheckboxModule,MatPaginatorModule
  ],
  exports: [
  CommonModule,
   MatToolbarModule, 
   MatButtonModule, 
   MatCardModule, 
   MatInputModule, 
   MatDialogModule, 
   MatTableModule, 
   MatMenuModule,
   MatIconModule,
   MatProgressSpinnerModule,
   MatSelectModule,
   MatSidenavModule,
   MatGridListModule,
   MatListModule,
   MatChipsModule,
   MatDatepickerModule,
   MatNativeDateModule,MatSnackBarModule,MatTooltipModule,
   MatCheckboxModule,MatPaginatorModule , MatSortModule,
   MatTabsModule,
   MatContenteditableModule,
   ],
})
export class CustomMaterial { }