import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { FileExplorerComponent } from './file-explorer.component';

const routes: Routes = [
  {
    path: 'files',
    component: FileExplorerComponent,
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class FileExploreRoutingModule { }
