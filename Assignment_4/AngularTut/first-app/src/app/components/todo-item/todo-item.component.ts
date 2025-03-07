import { Component, input } from '@angular/core';
import { HighlightCompletedTodoDirective } from '../../directives/highlight-completed-todo.directive';
import { Todo } from '../../model/todo.type';

@Component({
  selector: 'app-todo-item',
  imports: [HighlightCompletedTodoDirective],
  templateUrl: './todo-item.component.html',
  styleUrl: './todo-item.component.scss'
})
export class TodoItemComponent {
  todo = input.required<Todo>();
}
