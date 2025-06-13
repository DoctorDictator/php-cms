<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4" style="padding: 20px;">

    <!-- Blog Search Well -->
    <div style="background: #ffffff; padding: 20px; margin-bottom: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: all 0.3s ease; overflow: hidden; max-width: 100%; width: 100%; box-sizing: border-box;">
        <h4 style="color: #333; margin-bottom: 15px; font-weight: 600; font-size: 18px; text-align: center;">Blog Search</h4>
        <form action="/cms/search/" method="post" style="display: flex; align-items: center; width: 100%;">
            <input name="search" type="text" style="flex-grow: 1; padding: 12px; border: 2px solid #007bff; border-right: none; border-radius: 8px 0 0 8px; outline: none; font-size: 14px; height: 48px; box-sizing: border-box; transition: border-color 0.3s ease, box-shadow 0.3s ease;" onfocus="this.style.borderColor='#0056b3'; this.style.boxShadow='0 0 5px #0056b3';" onblur="this.style.borderColor='#007bff'; this.style.boxShadow='none';">
            <button type="submit" name="submit" style="background: #007bff; color: #fff; border: 2px solid #007bff; border-left: none; border-radius: 0 8px 8px 0; padding: 12px 20px; cursor: pointer; height: 48px; box-sizing: border-box; transition: background 0.3s ease, transform 0.3s ease; font-size: 14px;" onmouseover="this.style.background='#0056b3'; this.style.transform='translateY(-2px);'" onmouseout="this.style.background='#007bff'; this.style.transform='translateY(0);'">
                <span class="glyphicon glyphicon-search" style="vertical-align: middle; line-height: 24px;"></span>
            </button>
        </form>
    </div>

    <!-- Login -->
    <div class="well" style="background: #ffffff; padding: 20px; margin-bottom: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: box-shadow 0.3s ease;">
        <?php if (isset($_SESSION['user_role'])): ?>
            <h4 style="color: #333; margin-bottom: 15px; font-weight: 600;">Logged in as <span style="color: #007bff;"><?php echo $_SESSION['username'] ?></span></h4>
            <a href="/cms/includes/logout.php" class="btn btn-danger" style="width: 100%; padding: 12px; font-weight: 600; border-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.2)'" onmouseout="this.style.boxShadow='none'">Logout</a>
        <?php else: ?>
            <h4 style="color: #333; margin-bottom: 20px; font-weight: 600; text-align: center;">Login</h4>
            <form method="post" action="/cms/login.php">
                <div class="form-group" style="margin-bottom: 15px;">
                    <input name="username" type="text" class="form-control" placeholder="Username" style="width: 100%; padding: 12px 15px; border: 2px solid #007bff; border-radius: 8px; outline: none; font-size: 14px; transition: border-color 0.3s ease, box-shadow 0.3s ease;" onfocus="this.style.borderColor='#0056b3'; this.style.boxShadow='0 0 5px #0056b3';" onblur="this.style.borderColor='#007bff'; this.style.boxShadow='none';">
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <input name="password" type="password" class="form-control" placeholder="Password" style="width: 100%; padding: 12px 15px; border: 2px solid #007bff; border-radius: 8px; outline: none; font-size: 14px; transition: border-color 0.3s ease, box-shadow 0.3s ease;" onfocus="this.style.borderColor='#0056b3'; this.style.boxShadow='0 0 5px #0056b3';" onblur="this.style.borderColor='#007bff'; this.style.boxShadow='none';">
                </div>

                <button type="submit" name="login" style="background: #007bff; color: white; border: none; width: 100%; padding: 12px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: background 0.3s ease, transform 0.3s ease;" onmouseover="this.style.background='#0056b3'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#007bff'; this.style.transform='translateY(0)'">
                    Login
                </button>

                <div style="text-align: right; margin-top: 10px;">
                    <a href="forgot.php?forgot=<?php echo uniqid(true); ?>" style="color: #007bff; font-size: 13px; text-decoration: none;" onmouseover="this.style.color='#0056b3'" onmouseout="this.style.color='#007bff'">
                        Forgot Password?
                    </a>
                </div>
            </form>
        <?php endif; ?>
    </div>


    <!-- Blog Categories Well -->
    <div style="background: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: box-shadow 0.3s ease; overflow: hidden; max-width: 100%; width: 100%; box-sizing: border-box; position: relative;">
        <h4 style="color: #333; margin-bottom: 15px; font-weight: 600; font-size: 18px; text-align: center;">Blog Categories</h4>
        <ul id="category-list" style="list-style: none; padding: 0; display: flex; flex-wrap: wrap; gap: 10px; min-height: 60px; transition: all 0.3s ease; position: relative;">
            <?php
            $query = "SELECT * FROM categories";
            $select_categories_sidebar = mysqli_query($connection, $query);
            $categories = [];
            while ($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                $categories[] = $row;
            }
            foreach ($categories as $index => $row) {
                $cat_title = $row['cat_title'];
                $cat_id = $row['cat_id'];
                echo "<li draggable='true' data-index='$index' style='background: #f8f9fa; color: #333; padding: 10px 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease, opacity 0.3s ease; cursor: move; display: flex; align-items: center; justify-content: center; min-width: 100px; user-select: none; position: relative; z-index: 10;' ondragstart='dragStart(event)' ondragover='dragOver(event)' ondragenter='dragEnter(event)' ondragleave='dragLeave(event)' ondrop='drop(event)'>
                <a href='/cms/category/$cat_title' style='color: #333; text-decoration: none; width: 100%; text-align: center; '>$cat_title</a>
            </li>";
            }
            ?>
        </ul>
    </div>
    <script>
        document.querySelectorAll('#category-list li').forEach(item => {
            item.addEventListener('click', function() {
                const anchor = this.querySelector('a');
                if (anchor) {
                    window.location.href = anchor.href;
                }
            });

            // Optional: For double-click redirect (use one or the other)
            // item.addEventListener('dblclick', function () {
            //     const anchor = this.querySelector('a');
            //     if (anchor) {
            //         window.location.href = anchor.href;
            //     }
            // });
        });
    </script>

    <script>
        let draggedItem = null;
        let draggedOverItem = null;
        const list = document.getElementById('category-list');
        const items = Array.from(list.children);

        function dragStart(event) {
            draggedItem = event.target;
            draggedItem.style.opacity = '0.5';
            event.dataTransfer.setData('text/plain', draggedItem.getAttribute('data-index'));
            event.dataTransfer.effectAllowed = 'move';
            draggedItem.style.zIndex = '100';
        }

        function dragOver(event) {
            event.preventDefault();
            event.dataTransfer.dropEffect = 'move';
        }

        function dragEnter(event) {
            if (event.target.tagName === 'LI' && event.target !== draggedItem) {
                draggedOverItem = event.target;
                const fromIndex = parseInt(draggedItem.getAttribute('data-index'));
                const toIndex = parseInt(draggedOverItem.getAttribute('data-index'));
                animateSlide(fromIndex, toIndex);
            }
        }

        function dragLeave(event) {
            if (event.target.tagName === 'LI' && event.target === draggedOverItem) {
                draggedOverItem = null;
                resetPositions();
            }
        }

        function drop(event) {
            event.preventDefault();
            if (draggedItem && draggedOverItem) {
                const fromIndex = parseInt(event.dataTransfer.getData('text/plain'));
                const toIndex = Array.from(list.children).indexOf(draggedOverItem);
                if (toIndex >= 0 && fromIndex !== toIndex) {
                    const items = Array.from(list.children);
                    const dragged = items[fromIndex];
                    items.splice(fromIndex, 1);
                    items.splice(toIndex, 0, dragged);
                    list.innerHTML = '';
                    items.forEach((item, index) => {
                        item.setAttribute('data-index', index);
                        list.appendChild(item);
                    });
                    draggedItem.style.opacity = '1';
                    draggedItem.style.zIndex = '10';
                    draggedItem = null;
                    draggedOverItem = null;
                    resetPositions();
                }
            }
        }

        function animateSlide(fromIndex, toIndex) {
            const items = Array.from(list.children);
            const direction = toIndex > fromIndex ? 1 : -1;
            for (let i = fromIndex; i !== toIndex; i += direction) {
                const item = items[i + direction];
                const translateValue = direction === 1 ? '100px' : '-100px';
                item.style.transform = `translateX(${translateValue})`;
                item.style.transition = 'transform 0.3s ease';
            }
            setTimeout(() => {
                resetPositions();
                draggedOverItem.style.transform = 'translateX(0)';
                draggedOverItem.style.transition = 'transform 0.3s ease';
            }, 300);
        }

        function resetPositions() {
            const items = Array.from(list.children);
            items.forEach(item => {
                item.style.transform = 'translateX(0)';
                item.style.transition = 'transform 0.3s ease';
            });
        }

        // Add hover and drag effects
        const categoryItems = document.querySelectorAll('#category-list li');
        categoryItems.forEach(item => {
            item.addEventListener('dragenter', () => {
                if (item !== draggedItem) {
                    item.style.boxShadow = '0 4px 15px rgba(0,0,0,0.2)';
                    item.style.transform = 'translateY(-3px)';
                }
            });
            item.addEventListener('dragleave', () => {
                if (item !== draggedItem) {
                    item.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
                    item.style.transform = 'translateY(0)';
                }
            });
            item.addEventListener('dragend', () => {
                draggedItem.style.opacity = '1';
                draggedItem.style.zIndex = '10';
                resetPositions();
            });
        });

        // Handle window resize to maintain layout
        window.addEventListener('resize', () => {
            resetPositions();
        });

        // Ensure initial state
        window.addEventListener('load', () => {
            resetPositions();
        });
    </script>

    <!-- Side Widget Well -->
    <?php //include "widget.php"; 
    ?>
</div>