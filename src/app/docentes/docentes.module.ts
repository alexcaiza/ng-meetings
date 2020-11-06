import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import {TableModule} from 'primeng/table';
import {DialogModule} from 'primeng/dialog';
import {ButtonModule} from 'primeng/button';
import {ScrollPanelModule} from 'primeng/scrollpanel';
import {DropdownModule} from 'primeng/dropdown';


import { DocentesRoutingModule } from './docentes-routing.module';
import { DocentesMainComponent } from './docentes-main/docentes-main.component';
import { DocentesNavComponent } from './docentes-nav/docentes-nav.component';
import { DocentesMeetingListComponent } from './docentes-meeting-list/docentes-meeting-list.component';
import { DocentesMeetingProcessComponent } from './docentes-meeting-process/docentes-meeting-process.component';

import { FieldPipe } from '../services/pipes/field.pipe';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';


@NgModule({
  declarations: [
    DocentesMainComponent, 
    DocentesNavComponent, 
    DocentesMeetingListComponent, 
    DocentesMeetingProcessComponent,
    FieldPipe
  ],
  imports: [
    CommonModule,
    DocentesRoutingModule,
    TableModule,
    DialogModule,
    DropdownModule,
    ButtonModule,
    ScrollPanelModule,
    FormsModule,
    ReactiveFormsModule
  ]
})
export class DocentesModule { }
