// $(document).ready(function () {
//     $('.delete-button').click(function (event) {
//         event.preventDefault();

//         var itemId = $(this).data('item-id');
//         var itemType = $(this).data('item-type');

//         console.log("Item ID:", itemId);
//         console.log("Item Type:", itemType);

//         Swal.fire({
//             title: "Are you sure?",
//             text: "You want to delete the " + itemType + "?",
//             icon: "warning",
//             showCancelButton: true,
//             confirmButtonColor: "#DD6B55",
//             confirmButtonText: "Yes, delete it!",
//             cancelButtonText: "No, cancel",
//         }).then((result) => {
//             if (result.isConfirmed) {
//                 $(this).closest('form').submit();
//             }
//         });
//     });
// });
