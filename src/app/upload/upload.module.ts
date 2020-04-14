import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MatToolbarModule } from '@angular/material/toolbar';
import { FlexLayoutModule } from '@angular/flex-layout';
import { MatIconModule } from '@angular/material/icon';
import { MatGridListModule } from '@angular/material/grid-list';
import { MatMenuModule } from '@angular/material/menu';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatDialogModule } from '@angular/material/dialog';
import { MatInputModule } from '@angular/material/input';
import { UploadDialogComponent } from './upload-dialog/upload-dialog.component';
import { UploadComponent} from './upload.component';
import { MatButtonModule } from '@angular/material/button';
import { FormsModule } from '@angular/forms';
import { RenamefolderdiaologComponent } from '../file-explorer/renamefolderdiaolog/renamefolderdiaolog.component';
import { FileExplorerComponent } from '../file-explorer/file-explorer.component';
import { MatProgressBarModule, MatListModule } from '@angular/material';
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
    MatButtonModule,MatProgressBarModule,MatListModule
  ],
  declarations: [UploadDialogComponent,UploadComponent],
  exports: [UploadComponent],
  entryComponents: [UploadDialogComponent]
})
export class UploadModule {}
