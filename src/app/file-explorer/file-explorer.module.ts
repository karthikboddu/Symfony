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
import { NewfolderdiaologComponent } from './newfolderdiaolog/newfolderdiaolog.component';
import { MatButtonModule } from '@angular/material/button';
import { FormsModule } from '@angular/forms';
import { RenamefolderdiaologComponent } from './renamefolderdiaolog/renamefolderdiaolog.component';
import { FileExplorerComponent } from './file-explorer.component';

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
    MatButtonModule
  ],
  declarations: [FileExplorerComponent, NewfolderdiaologComponent, RenamefolderdiaologComponent],
  exports: [FileExplorerComponent],
  entryComponents: [NewfolderdiaologComponent, RenamefolderdiaologComponent]
})
export class FileExplorerModule {}
