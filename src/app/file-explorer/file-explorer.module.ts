import { NgModule, NO_ERRORS_SCHEMA, CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MatToolbarModule } from '@angular/material/toolbar';
import { FlexLayoutModule } from '@angular/flex-layout';
import { MatIconModule } from '@angular/material/icon';
import { MatGridListModule } from '@angular/material/grid-list';
import { MatMenuModule } from '@angular/material/menu';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatDialogModule } from '@angular/material/dialog';
import { MatInputModule } from '@angular/material/input';
import { NewfolderdiaologComponent } from './newfolderdiaolog/newfolderdiaolog.component';
import { MatButtonModule } from '@angular/material/button';
import { FormsModule } from '@angular/forms';
import { RenamefolderdiaologComponent } from './renamefolderdiaolog/renamefolderdiaolog.component';
import { FileExplorerComponent } from './file-explorer.component';
import { FileExplorerDashboardComponent } from './file-explorer-dashboard/file-explorer-dashboard.component';
import { CustomMaterial } from '../material.module';
import { UploadModule } from '../upload/upload.module';
@NgModule({
  imports: [
    CommonModule,
    MatToolbarModule,
    FlexLayoutModule,
    MatIconModule,
    MatGridListModule,
    MatMenuModule,
    BrowserAnimationsModule,
    MatDialogModule,
    MatInputModule,
    FormsModule,
    MatButtonModule,
    CustomMaterial,UploadModule
  ],
  declarations: [FileExplorerComponent, NewfolderdiaologComponent, RenamefolderdiaologComponent,FileExplorerDashboardComponent],
  exports: [FileExplorerComponent,FileExplorerDashboardComponent],
  entryComponents: [NewfolderdiaologComponent, RenamefolderdiaologComponent],
  schemas: [ CUSTOM_ELEMENTS_SCHEMA ,NO_ERRORS_SCHEMA]
})
export class FileExplorerModule {}
