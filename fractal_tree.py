import turtle as t


screen = t.Screen()
screen.bgcolor("black")
screen.title("Фрактальное дерево")


tree_turtle = t.Turtle()
tree_turtle.speed(0)
tree_turtle.color('green')
tree_turtle.pensize(2)
tree_turtle.left(90)  

def draw_tree(branch_length):
    if branch_length > 5:
        tree_turtle.forward(branch_length)
        new_branch_len = branch_length * 0.8 
        
     
        tree_turtle.right(25)
        draw_tree(new_branch_len)
        
      
        tree_turtle.left(50)
        draw_tree(new_branch_len)
        
       
        tree_turtle.right(25)
        tree_turtle.backward(branch_length)


tree_turtle.up()      
tree_turtle.setpos(0,-200)   
tree_turtle.down()     

draw_tree(100)  


tree_turtle.hideturtle()
screen.exitonclick()
