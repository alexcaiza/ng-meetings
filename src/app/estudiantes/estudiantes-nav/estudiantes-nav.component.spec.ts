import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EstudiantesNavComponent } from './estudiantes-nav.component';

describe('EstudiantesNavComponent', () => {
  let component: EstudiantesNavComponent;
  let fixture: ComponentFixture<EstudiantesNavComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ EstudiantesNavComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(EstudiantesNavComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
