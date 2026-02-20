import tkinter as tk

# Initialize the main window
root = tk.Tk()
root.title("Bouncing Ball in a Square")
canvas = tk.Canvas(root, width=400, height=400, bg='white')
canvas.pack()

# Ball properties
radius = 10
initial_x = 200  # Center of the canvas horizontally
initial_y = 200  # Center of the canvas vertically
dx = 5  # Change in x (velocity in x-direction)
dy = 5  # Change in y (velocity in y-direction)

# Create the ball on the canvas
ball = canvas.create_oval(initial_x - radius, initial_y - radius,
                          initial_x + radius, initial_y + radius,
                          fill='blue')

# Update function to move the ball and handle bouncing
def update():
    global dx, dy
    # Get current coordinates of the ball (bounding box: x1, y1, x2, y2)
    coords = canvas.coords(ball)
    x1, y1, x2, y2 = coords
    # Calculate the center of the ball
    center_x = (x1 + x2) / 2
    center_y = (y1 + y2) / 2

    # Check for collision with left or right wall
    if center_x - radius <= 0 or center_x + radius >= 400:
        dx = -dx  # Reverse x-direction velocity
    # Check for collision with top or bottom wall
    if center_y - radius <= 0 or center_y + radius >= 400:
        dy = -dy  # Reverse y-direction velocity

    # Move the ball by dx and dy
    canvas.move(ball, dx, dy)
    # Schedule the next update after 50 milliseconds
    canvas.after(50, update)

# Start the animation
update()

# Run the main event loop
root.mainloop()