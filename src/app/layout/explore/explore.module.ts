import { NgModule, NO_ERRORS_SCHEMA, CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ExploreComponent } from './explore.component';
import { CategoryDisplayComponent } from './category-display/category-display.component';
import { CategoryPostsComponent } from './category-display/category-posts/category-posts.component';
import { PostFilterComponent } from '../post-filter/post-filter.component';
import { InfiniteScrollModule } from 'ngx-infinite-scroll';
import { PostDisplayComponent } from './post-display/post-display.component';
import {CustomMaterial} from '../../material.module';
import {FlexLayoutModule} from '@angular/flex-layout';
@NgModule({
  declarations: [ExploreComponent,CategoryDisplayComponent,
    CategoryPostsComponent,PostFilterComponent,PostDisplayComponent],
  imports: [
    CommonModule,InfiniteScrollModule,CustomMaterial,FlexLayoutModule
  ],
  exports: [CategoryPostsComponent,CategoryDisplayComponent,PostDisplayComponent,PostFilterComponent],
  entryComponents: [ExploreComponent],
  schemas: [ CUSTOM_ELEMENTS_SCHEMA ,NO_ERRORS_SCHEMA]
})
export class ExploreModule { }
