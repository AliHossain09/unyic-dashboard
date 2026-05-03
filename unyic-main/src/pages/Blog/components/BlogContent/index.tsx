import CommentBox from "./CommentBox";

const BlogContent = () => {
  return (
    <div>
      <p className="text-dark mb-6 text-lg">
        Lorem ipsum dolor sit, amet consectetur adipisicing elit. At
        perspiciatis consectetur quidem quasi soluta voluptatem, nobis possimus.
        Labore, obcaecati itaque natus vitae aspernatur doloribus repudiandae
        explicabo cupiditate recusandae eius reiciendis impedit similique esse
        sint consequuntur. Maiores tempora dolor eius quae.
      </p>

      <img src="https://picsum.photos/1920/1080" />

      <h2 className="font-semibold text-3xl mt-8">Large Caption</h2>

      <p className="mt-2 text-dark text-lg">
        Lorem ipsum dolor sit, amet consectetur adipisicing elit. At
        perspiciatis consectetur quidem quasi soluta voluptatem, nobis possimus.
        Labore, obcaecati itaque natus vitae aspernatur doloribus repudiandae
        explicabo cupiditate recusandae eius reiciendis impedit similique esse
        sint consequuntur. Maiores tempora dolor eius quae.
      </p>

      <CommentBox />
    </div>
  );
};

export default BlogContent;
